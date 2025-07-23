<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\CustomerBook;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Set lokal tanggal ke Indonesia
        Carbon::setLocale('id');

View::composer('*', function ($view) {
    $pendingCount = 0;

    if (auth()->check() && auth()->user()->level === 'admin') {
        // CAST ke DECIMAL lalu bandingkan = 0
        $pendingCount = CustomerBook::whereRaw('CAST(price AS DECIMAL) = 0')->count();
    }

    $view->with('pendingCount', $pendingCount);
});

    }
}
