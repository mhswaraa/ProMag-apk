<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Kpi;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil Statistik Presensi
        $totalHadir = Attendance::where('user_id', $userId)->where('status', 'hadir')->count();
        $totalIzin = Attendance::where('user_id', $userId)->where('status', 'izin')->count();
        $totalSakit = Attendance::where('user_id', $userId)->where('status', 'sakit')->count();

        // 2. Ambil Ringkasan KPI
        $totalKpi = Kpi::where('user_id', $userId)->count();
        $kpiCompleted = Kpi::where('user_id', $userId)->where('status', 'completed')->count();
        
        // Hitung persentase progress KPI
        $kpiProgress = $totalKpi > 0 ? round(($kpiCompleted / $totalKpi) * 100) : 0;

        // 3. Ambil Skill yang sedang dipelajari
        $skills = Skill::where('user_id', $userId)->latest()->take(3)->get();

        return view('dashboard', compact(
            'totalHadir', 
            'totalIzin', 
            'totalSakit', 
            'totalKpi', 
            'kpiProgress', 
            'skills'
        ));
    }
}