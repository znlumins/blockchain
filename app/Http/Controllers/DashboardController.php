<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        $role = Auth::user()->role;
        
        if ($role == 'admin' || $role == 'auditor') {
            $totalProyek = Project::count();
            $totalWarga = User::where('role', 'warga')->count();
            $totalVoting = Vote::count();
            $proyekTerbaru = Project::latest()->take(5)->get();
            
            return view('admin.dashboard', compact('totalProyek', 'totalWarga', 'totalVoting', 'proyekTerbaru'));
        } 
        
        // Untuk Warga
        $proyekTersedia = Project::where('status', 'usulan')->get();
        return view('user.dashboard', compact('proyekTersedia'));
    }
}