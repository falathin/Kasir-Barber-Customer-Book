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
     */public function boot(): void
        {
            Carbon::setLocale('id');

        View::composer('*', function ($view) {
            if (auth()->check() && auth()->user()->level === 'admin') {
                $pendingCount = CustomerBook::where('price', 0)
                    ->whereNull('colouring_other')
                    ->count();

                $view->with('pendingCount', $pendingCount);
            }
    });

        }
}
