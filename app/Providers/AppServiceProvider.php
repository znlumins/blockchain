<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Project;
use App\Models\Vote;
use App\Models\FinancialReport;
use App\Models\ProjectDocument;
use App\Observers\BlockchainObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Mendaftarkan Observer untuk "Simulasi Blockchain"
        // Setiap kali ada perubahan pada model-model ini,
        // BlockchainObserver akan otomatis mencatatnya.
        Project::observe(BlockchainObserver::class);
        Vote::observe(BlockchainObserver::class);
        FinancialReport::observe(BlockchainObserver::class);
        ProjectDocument::observe(BlockchainObserver::class); // <-- Nanti untuk fitur upload

        // 2. Mendaftarkan Gate untuk otorisasi (Pembatasan Hak Akses)
        // Ini membuat middleware 'can:admin' di routes/web.php berfungsi.
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        // (Opsional) Gate untuk warga, jika nanti dibutuhkan
        Gate::define('warga', function (User $user) {
            return $user->role === 'warga';
        });
    }
}