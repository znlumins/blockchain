<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Vote;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Menampilkan Detail Proyek (Untuk Admin & Warga)
     */
    public function show($id)
    {
        // 1. Ambil data proyek beserta laporan keuangan dan dokumennya
        $project = Project::with(['financials', 'documents'])->findOrFail($id);
        
        // 2. Hitung statistik voting warga
        $setuju = Vote::where('project_id', $id)->where('suara', 'setuju')->count();
        $tidak_setuju = Vote::where('project_id', $id)->where('suara', 'tidak_setuju')->count();
        
        // 3. Ambil data LOG BLOCKCHAIN (Simulasi)
        $blockchainLogs = AuditLog::where(function($query) use ($id) {
            $query->where('model_id', $id)
                  ->where('model_type', 'App\Models\Project');
        })->orWhere(function($query) use ($id) {
            $query->where('model_type', 'App\Models\Vote')
                  ->where('data->project_id', $id);
        })->orWhere(function($query) use ($id) {
            $query->where('model_type', 'App\Models\FinancialReport')
                  ->where('data->project_id', $id);
        })->latest()->get();

        /**
         * PERBAIKAN DI SINI:
         * Kita arahkan ke 'admin.projects.detail' karena file kamu ada di:
         * resources/views/admin/projects/detail.blade.php
         */
        return view('admin.projects.detail', compact('project', 'setuju', 'tidak_setuju', 'blockchainLogs'));
    }

    /**
     * Menangani Voting dari Warga
     */
    public function vote(Request $request, $id)
    {
        $request->validate(['suara' => 'required|in:setuju,tidak_setuju']);
        
        Vote::updateOrCreate(
            ['user_id' => Auth::id(), 'project_id' => $id],
            ['suara' => $request->suara]
        );

        return back()->with('success', 'Pilihan suara Anda telah direkam secara permanen ke dalam sistem Blockchain.');
    }
}