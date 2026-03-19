<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Models\Project;
use App\Models\Vote;
use App\Models\FinancialReport;
use App\Observers\BlockchainObserver;

class AppServiceProvider extends ServiceProvider {
    public function boot(): void {
        // Setiap ada project/vote/keuangan baru, otomatis masuk ke blockchain log
        Project::observe(BlockchainObserver::class);
        Vote::observe(BlockchainObserver::class);
        FinancialReport::observe(BlockchainObserver::class);
    }
}
