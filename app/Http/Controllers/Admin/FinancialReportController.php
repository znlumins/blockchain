<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\FinancialReport;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    // Menampilkan Laporan Keuangan untuk Proyek Tertentu
    public function index(Project $project)
    {
        $financials = $project->financials()->latest()->get();
        
        // Hitung otomatis seperti di PPT Halaman 5
        $totalTerpakai = $financials->where('jenis', 'pengeluaran')->sum('jumlah');
        $sisaAnggaran = $project->anggaran - $totalTerpakai;

        return view('admin.financials.index', compact('project', 'financials', 'totalTerpakai', 'sisaAnggaran'));
    }

    // Menyimpan data pengeluaran/pemasukan baru
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'jenis' => 'required|in:pengeluaran,pemasukan',
            'uraian' => 'required|string|max:255',
            'volume' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:50',
            'harga_satuan' => 'nullable|numeric',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $project->financials()->create([
            'jenis' => $request->jenis,
            'uraian' => $request->uraian,
            'volume' => $request->volume,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
            'jumlah' => $request->jumlah,
        ]);

        return back()->with('success', 'Data laporan keuangan berhasil ditambahkan dan dicatat di Blockchain!');
    }

    // Menghapus data keuangan
    public function destroy(Project $project, FinancialReport $financial)
    {
        $financial->delete();
        return back()->with('success', 'Data laporan keuangan berhasil dihapus.');
    }
}