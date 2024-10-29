<?php

namespace App\Providers;

use GuzzleHttp\Middleware;
use Illuminate\Pagination\Paginator;
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

    /*
     * Pagination işlemlerinde bootstrap 5 kullanılması için
     * Farklı bir tema kullanılacaksa ilgili tema için uygun olan paginator kullanılmalıdır.
     * */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

    }
}
