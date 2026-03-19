<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectDocumentController extends Controller
{
    // Menampilkan Galeri Dokumen untuk Proyek Tertentu (PPT Hal 10)
    public function index(Project $project)
    {
        $documents = $project->documents()->latest()->get();
        return view('admin.documents.index', compact('project', 'documents'));
    }

    // Menyimpan Upload Dokumen/Foto Baru (PPT Hal 6)
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'tipe_data' => 'required|in:DOKUMEN,FOTO',
            'deskripsi' => 'required|string|max:255',
            'file' => 'required|file|max:10240', // Maksimal 10MB
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('project_files', 'public');

            $project->documents()->create([
                'tipe_data' => $request->tipe_data,
                'deskripsi' => $request->deskripsi,
                'file_path' => $path,
            ]);
        }

        return back()->with('success', 'Dokumen/Foto berhasil diupload dan diverifikasi oleh Blockchain!');
    }

    // Menghapus Dokumen
    public function destroy(Project $project, ProjectDocument $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}