<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Vote;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller {
    public function show($id) {
        $project = Project::with(['financials', 'documents'])->findOrFail($id);
        $setuju = Vote::where('project_id', $id)->where('suara', 'setuju')->count();
        $tidak_setuju = Vote::where('project_id', $id)->where('suara', 'tidak_setuju')->count();
        
        // Ambil data blockchain untuk proyek ini
        $blockchainLogs = AuditLog::where('model_id', $id)->where('model_type', Project::class)
                                  ->orWhere('model_type', Vote::class)->latest()->get();

        return view('projects.detail', compact('project', 'setuju', 'tidak_setuju', 'blockchainLogs'));
    }

    public function vote(Request $request, $id) {
        $request->validate(['suara' => 'required|in:setuju,tidak_setuju']);
        
        Vote::updateOrCreate(
            ['user_id' => Auth::id(), 'project_id' => $id],
            ['suara' => $request->suara]
        );

        return back()->with('success', 'Vote berhasil dicatat dalam blockchain secara permanen.');
    }
}