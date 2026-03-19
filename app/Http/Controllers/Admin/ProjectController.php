<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'tahun' => 'required|digits:4|integer|min:2020',
            'status' => 'required|in:usulan,proses,selesai',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')->with('success', 'Proyek baru berhasil ditambahkan dan dicatat dalam blockchain.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Pastikan relasi juga terhapus jika ada (misal: votes, documents, dll)
        // Laravel akan handle ini jika foreign key di-setting dengan onDelete('cascade')
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dihapus.');
    }
}