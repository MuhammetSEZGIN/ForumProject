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
        $this->app->singleton('App\Services\FileService.excel', function ($app) {
            return new \App\Services\FileService(new \App\Modules\FileHandlers\ExcelHandler());
        });

        $this->app->singleton('App\Services\FileService.pdf', function ($app) {
            return new \App\Services\FileService(new \App\Modules\FileHandlers\PdfHandler());
        });
        $this->app->singleton('App\Services\FileService.word', function ($app) {
            return new \App\Services\FileService(new \App\Modules\FileHandlers\WordHandler());
        });


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
