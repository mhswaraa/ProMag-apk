<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DailyActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    /**
     * Menampilkan daftar riwayat presensi & statistik dashboard.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // --- KONFIGURASI PERIODE MAGANG ---
        $startDate = Carbon::create(2025, 11, 24); // Tanggal Mulai
        $endDate = Carbon::create(2026, 05, 23);   // Tanggal Selesai
        // ----------------------------------

        // 1. Logika Navigasi Bulan (Untuk Kalender)
        if ($request->has('month') && $request->has('year')) {
            $currentDate = Carbon::createFromDate($request->year, $request->month, 1);
        } else {
            $currentDate = Carbon::now();
        }

        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();

        // 2. Ambil data presensi BULAN INI (Khusus untuk tampilan Kalender Grid)
        $attendances = Attendance::where('user_id', $userId)
                        ->whereMonth('date', $currentDate->month)
                        ->whereYear('date', $currentDate->year)
                        ->with('daily_activities')
                        ->get()
                        ->keyBy('date');

        // 3. Hitung Statistik KESELURUHAN (GLOBAL / ALL TIME)
        // Kita query ulang tanpa filter bulan/tahun untuk mendapatkan total akumulasi
        $allAttendances = Attendance::where('user_id', $userId)->get();

        $totalHadir = $allAttendances->where('status', 'hadir')->count();
        $totalIzin = $allAttendances->where('status', 'izin')->count();
        $totalSakit = $allAttendances->where('status', 'sakit')->count();
        
        // --- LOGIKA BARU: HITUNG AUTO ALPHA & PERSENTASE KEHADIRAN ---
        
        $today = Carbon::now()->startOfDay();
        // Batasi perhitungan sampai hari ini atau tanggal selesai magang (jika sudah lewat)
        $calculationLimit = $today->gt($endDate) ? $endDate : $today;
        
        $autoAlpa = 0;
        $tempDate = $startDate->copy()->startOfDay();

        // Ambil daftar tanggal yang sudah ada statusnya (hadir/izin/sakit/alpa)
        $recordedDates = $allAttendances->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('Y-m-d');
        })->toArray();

        // Loop dari hari pertama sampai hari ini untuk mencari hari kosong (Alpha)
        while ($tempDate->lte($calculationLimit)) {
            // Cek apakah hari ini adalah Hari Kerja (Senin-Jumat)
            if ($tempDate->isWeekday()) {
                $dateString = $tempDate->format('Y-m-d');
                
                // Jika tanggal ini TIDAK ADA di database, hitung sebagai ALPA
                if (!in_array($dateString, $recordedDates)) {
                    $autoAlpa++;
                }
            }
            $tempDate->addDay();
        }

        // Tambahkan dengan Alpa manual yang mungkin diinput di DB
        $manualAlpa = $allAttendances->where('status', 'alpa')->count();
        $totalAlpa = $autoAlpa + $manualAlpa;

        // HITUNG PERSENTASE KEHADIRAN (Attendance Rate)
        // Total Hari Kerja Berlalu = Hadir + Izin + Sakit + Alpha (Auto & Manual)
        $totalElapsedWorkdays = $totalHadir + $totalIzin + $totalSakit + $totalAlpa;
        
        // Rumus: (Total Hadir / Total Hari Kerja Berlalu) * 100
        $attendanceRate = $totalElapsedWorkdays > 0 ? round(($totalHadir / $totalElapsedWorkdays) * 100) : 0;
        // --------------------------------------

        // Hitung Total Jam Kerja Keseluruhan
        $totalSeconds = 0;
        foreach($allAttendances as $att) {
            if($att->status == 'hadir' && $att->check_in && $att->check_out) {
                $start = Carbon::parse($att->check_in);
                $end = Carbon::parse($att->check_out);
                $totalSeconds += $end->diffInSeconds($start);
            }
        }
        $totalHours = $totalSeconds > 0 ? round($totalSeconds / 3600, 1) : 0;
        
        // Rata-rata jam kerja (Keseluruhan)
        $avgHours = $totalHadir > 0 ? round($totalHours / $totalHadir, 1) : 0;

        // 4. Hitung Total Aktivitas (Keseluruhan)
        $totalLearning = DailyActivity::whereHas('attendance', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('type', 'learning')->count();

        $totalExecution = DailyActivity::whereHas('attendance', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('type', 'execution')->count();

        // 5. Hitung KPI Progress Masa Magang
        $totalDaysInternship = $startDate->diffInDays($endDate); 
        $daysPassed = $startDate->startOfDay()->diffInDays($today);
        
        if ($today->lt($startDate)) {
            $magangProgress = 0;
            $daysPassed = 0;
        } elseif ($today->gt($endDate)) {
            $magangProgress = 100;
            $daysPassed = $totalDaysInternship;
        } else {
            $magangProgress = round(($daysPassed / $totalDaysInternship) * 100);
        }
        $daysRemaining = max(0, $totalDaysInternship - $daysPassed);

        return view('attendances.index', compact(
            'attendances', // Data bulan ini (untuk kalender)
            'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpa', 'attendanceRate', // Data Global
            'totalHours', 'avgHours', // Data Global
            'totalLearning', 'totalExecution', // Data Global
            'magangProgress', 'daysPassed', 'totalDaysInternship', 'daysRemaining',
            'currentDate', 'prevMonth', 'nextMonth'
        ));
    }

    /**
     * Menampilkan form input presensi baru.
     */
    public function create()
    {
        return view('attendances.create');
    }

    /**
     * Menyimpan data presensi dan logbook ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit',
        ]);

        $user = Auth::user();

        // 1. Simpan Data Presensi (Tabel Parent)
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => Carbon::today(), // Otomatis tanggal hari ini
            'status' => $request->status,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'notes' => $request->notes,
            'mood' => 'neutral',
        ]);

        // 2. Simpan Detail Kegiatan (Tabel Child) - Hanya jika Hadir
        if ($request->status == 'hadir' && $request->has('activities')) {
            foreach ($request->activities as $activity) {
                // Pastikan tidak menyimpan baris kosong
                if (!empty($activity['title'])) {
                    DailyActivity::create([
                        'attendance_id' => $attendance->id,
                        'type' => $activity['type'],
                        'title' => $activity['title'],
                        'description' => $activity['description'] ?? '',
                        'obstacles' => $activity['obstacles'] ?? null,     // Kendala
                        'improvements' => $activity['improvements'] ?? null, // Improvement
                        'duration_minutes' => 60, // Default duration
                    ]);
                }
            }
        }

        return redirect()->route('attendances.index')->with('success', 'Presensi berhasil dicatat!');
    }

    /**
     * Menampilkan halaman EDIT form.
     */
    public function edit(Attendance $attendance)
    {
        // Pastikan yang diedit adalah milik user sendiri
        if ($attendance->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Load data aktivitasnya
        $attendance->load('daily_activities');

        return view('attendances.edit', compact('attendance'));
    }

    /**
     * Proses UPDATE data ke database.
     */
    public function update(Request $request, Attendance $attendance)
    {
        // Validasi User
        if ($attendance->user_id !== Auth::id()) {
            abort(403);
        }

        // 1. Update Data Induk (Attendance)
        $attendance->update([
            'status' => $request->status,
            'check_in' => $request->status == 'hadir' ? $request->check_in : null,
            'check_out' => $request->status == 'hadir' ? $request->check_out : null,
            'notes' => $request->status != 'hadir' ? $request->notes : null,
        ]);

        // 2. Update Aktivitas (Cara Bersih: Hapus Lama, Buat Baru)
        $attendance->daily_activities()->delete();

        if ($request->status == 'hadir' && $request->has('activities')) {
            foreach ($request->activities as $activity) {
                if (!empty($activity['title'])) {
                    DailyActivity::create([
                        'attendance_id' => $attendance->id,
                        'type' => $activity['type'],
                        'title' => $activity['title'],
                        'description' => $activity['description'] ?? '',
                        'obstacles' => $activity['obstacles'] ?? null,     // Kendala
                        'improvements' => $activity['improvements'] ?? null, // Improvement
                        'duration_minutes' => 60,
                    ]);
                }
            }
        }

        return redirect()->route('attendances.index')->with('success', 'Logbook berhasil diperbarui!');
    }

    /**
     * Download Laporan PDF
     */
    public function downloadPdf(Request $request)
    {
        $userId = Auth::id();
        
        // Default: Periode Bulan Ini jika tidak ada input tanggal
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfMonth();

        // Ambil Data Presensi dalam Rentang Tanggal
        $attendances = Attendance::where('user_id', $userId)
                        ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                        ->with('daily_activities')
                        ->orderBy('date', 'asc')
                        ->get();

        // Hitung Ringkasan untuk Header Laporan
        $summary = [
            'hadir' => $attendances->where('status', 'hadir')->count(),
            'izin' => $attendances->where('status', 'izin')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
            'alpa' => $attendances->where('status', 'alpa')->count(),
            'total_jam' => 0
        ];

        foreach($attendances as $att) {
            if($att->check_in && $att->check_out) {
                $start = Carbon::parse($att->check_in);
                $end = Carbon::parse($att->check_out);
                $summary['total_jam'] += $end->diffInHours($start);
            }
        }

        // Load View PDF
        $pdf = Pdf::loadView('attendances.pdf', [
            'attendances' => $attendances,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'user' => Auth::user(),
            'summary' => $summary
        ]);

        // Setup Kertas A4 Portrait
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Magang_' . Auth::user()->name . '.pdf');
    }
}