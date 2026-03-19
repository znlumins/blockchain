<?php

use Illuminate\Support\Facades\Route;

// Import Controller Utama
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;

// Import Controller Folder Admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\FinancialReportController;
use App\Http\Controllers\Admin\ProjectDocumentController;
use App\Http\Controllers\Admin\BlockchainController;

/*
|--------------------------------------------------------------------------
| Web Routes SIPPD - Sistem Informasi Percepatan Pembangunan Daerah
|--------------------------------------------------------------------------
*/

// Halaman awal langsung diarahkan ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Grup Route yang harus Login dulu (Middleware Auth)
Route::middleware('auth')->group(function () {
    
    /**
     * DASHBOARD UTAMA
     * Logika tampilan Admin vs Warga diatur otomatis di DashboardController@index
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * HALAMAN DETAIL PROYEK & VOTING
     * Bisa diakses Admin maupun Warga
     */
    Route::get('/project/{id}', [ProjectController::class, 'show'])->name('project.detail');
    Route::post('/project/{id}/vote', [ProjectController::class, 'vote'])->name('project.vote');

    /**
     * FITUR PROFILE (Bawaan Laravel Breeze)
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * ------------------------------------------------------------------
     * AREA KHUSUS ADMIN (Middleware 'can:admin')
     * ------------------------------------------------------------------
     */
    Route::middleware('can:admin')->group(function () {
        
        // 1. MANAJEMEN PENGGUNA (PPT Hal 4)
        // Menambah dan menghapus user (warga/admin lain)
        Route::resource('users', UserController::class)->except(['show', 'edit', 'update']);
        
        // 2. MANAJEMEN DAFTAR PROYEK (PPT Hal 3)
        // Membuat proyek baru yang akan ditampilkan ke warga
        Route::resource('projects', AdminProjectController::class)->except(['show', 'edit', 'update']);

        // 3. LAPORAN KEUANGAN PROYEK (PPT Hal 5)
        // Mencatat pengeluaran/pemasukan dana proyek ke Blockchain
        Route::get('projects/{project}/financials', [FinancialReportController::class, 'index'])->name('projects.financials.index');
        Route::post('projects/{project}/financials', [FinancialReportController::class, 'store'])->name('projects.financials.store');
        Route::delete('projects/{project}/financials/{financial}', [FinancialReportController::class, 'destroy'])->name('projects.financials.destroy');

        // 4. DOKUMENTASI & FOTO PROYEK (PPT Hal 6 & 10)
        // Upload bukti fisik pekerjaan proyek
        Route::get('projects/{project}/documents', [ProjectDocumentController::class, 'index'])->name('projects.documents.index');
        Route::post('projects/{project}/documents', [ProjectDocumentController::class, 'store'])->name('projects.documents.store');
        Route::delete('projects/{project}/documents/{document}', [ProjectDocumentController::class, 'destroy'])->name('projects.documents.destroy');

        // 5. GLOBAL BLOCKCHAIN EXPLORER (PPT Hal 15)
        // Melihat semua buku besar transaksi (Audit Log)
        Route::get('/blockchain', [BlockchainController::class, 'index'])->name('blockchain.index');
    });

});

// Load route autentikasi bawaan Laravel Breeze (Login, Logout, dll)
require __DIR__.'/auth.php';