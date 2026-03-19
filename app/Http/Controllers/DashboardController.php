<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        
        // JIKA ADMIN (SESUAI PPT HAL 3)
        if ($role == 'admin' || $role == 'auditor') {
            $totalProyek = Project::count();
            $totalWarga = User::where('role', 'warga')->count();
            $totalVoting = Vote::count();
            
            // Hitung total anggaran (Simulasi di Dashboard)
            $totalAnggaran = Project::sum('anggaran');
            
            // Ambil 5 proyek terbaru
            $proyekTerbaru = Project::latest()->take(5)->get();
            
            return view('admin.dashboard', compact('totalProyek', 'totalWarga', 'totalVoting', 'totalAnggaran', 'proyekTerbaru'));
        } 
        
        // JIKA WARGA (SESUAI PPT HAL 9)
        $proyekTersedia = Project::where('status', 'usulan')->get();
        return view('user.dashboard', compact('proyekTersedia'));
    }
}