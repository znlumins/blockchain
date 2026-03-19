<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('login'); });

Route::middleware('auth')->group(function () {
    // Dashboard (Logika role ada di controller)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Project Detail & Voting
    Route::get('/project/{id}', [ProjectController::class, 'show'])->name('project.detail');
    Route::post('/project/{id}/vote', [ProjectController::class, 'vote'])->name('project.vote');

    // Profile bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';