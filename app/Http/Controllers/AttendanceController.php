<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DailyActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Menampilkan daftar riwayat presensi.
     */
    public function index()
    {
        $userId = Auth::id();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // 1. Ambil data presensi FULL satu bulan ini
        $attendances = Attendance::where('user_id', $userId)
                        ->whereMonth('date', $currentMonth)
                        ->whereYear('date', $currentYear)
                        ->with('daily_activities')
                        ->get()
                        ->keyBy('date');

        // 2. Hitung Statistik Presensi Bulan Ini
        $totalHadir = $attendances->where('status', 'hadir')->count();
        $totalIzin = $attendances->where('status', 'izin')->count();
        $totalSakit = $attendances->where('status', 'sakit')->count();
        $totalAlpa = $attendances->where('status', 'alpa')->count();
        
        // Hitung Jam Kerja Bulan Ini
        $totalSeconds = 0;
        foreach($attendances as $att) {
            if($att->check_in && $att->check_out) {
                $start = Carbon::parse($att->check_in);
                $end = Carbon::parse($att->check_out);
                $totalSeconds += $end->diffInSeconds($start);
            }
        }
        $totalHours = $totalSeconds > 0 ? round($totalSeconds / 3600, 1) : 0;
        $avgHours = $totalHadir > 0 ? round($totalHours / $totalHadir, 1) : 0;

        // 3. Hitung Total Aktivitas (Kumulatif Selama Magang)
        // Kita gunakan query terpisah agar menghitung semua data, bukan cuma bulan ini
        $totalLearning = DailyActivity::whereHas('attendance', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('type', 'learning')->count();

        $totalExecution = DailyActivity::whereHas('attendance', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('type', 'execution')->count();

        // 4. Hitung KPI Progress Masa Magang (Waktu)
        $startDate = Carbon::create(2024, 11, 24); // Tanggal Mulai
        $endDate = $startDate->copy()->addMonths(6); // Tanggal Selesai (6 Bulan)
        
        $totalDaysInternship = $startDate->diffInDays($endDate); // Total hari magang (misal 180 hari)
        $daysPassed = $startDate->diffInDays(Carbon::now()); // Hari yang sudah dilalui
        
        // Hitung Persentase (Cegah error jika belum mulai atau sudah lewat)
        if (Carbon::now()->lt($startDate)) {
            $magangProgress = 0;
        } else {
            $magangProgress = min(100, round(($daysPassed / $totalDaysInternship) * 100));
        }

        return view('attendances.index', compact(
            'attendances', 
            'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpa',
            'totalHours', 'avgHours',
            'totalLearning', 'totalExecution', 
            'magangProgress', 'daysPassed', 'totalDaysInternship'
        ));
    }

    public function create()
    {
        return view('attendances.create');
    }

    public function store(Request $request)
    {
        // ... (Validasi & Logic Store sama seperti sebelumnya) ...
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit',
        ]);

        $user = Auth::user();

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'status' => $request->status,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'notes' => $request->notes,
            'mood' => 'neutral',
        ]);

        if ($request->status == 'hadir' && $request->has('activities')) {
            foreach ($request->activities as $activity) {
                if (!empty($activity['title'])) {
                    DailyActivity::create([
                        'attendance_id' => $attendance->id,
                        'type' => $activity['type'],
                        'title' => $activity['title'],
                        'description' => $activity['description'] ?? '',
                        'duration_minutes' => 60,
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
        // Ini cara paling aman untuk menangani dynamic form (add/remove row)
        $attendance->daily_activities()->delete();

        if ($request->status == 'hadir' && $request->has('activities')) {
            foreach ($request->activities as $activity) {
                if (!empty($activity['title'])) {
                    DailyActivity::create([
                        'attendance_id' => $attendance->id,
                        'type' => $activity['type'],
                        'title' => $activity['title'],
                        'description' => $activity['description'] ?? '',
                        'duration_minutes' => 60,
                    ]);
                }
            }
        }

        return redirect()->route('attendances.index')->with('success', 'Logbook berhasil diperbarui!');
    }
}