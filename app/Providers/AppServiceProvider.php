<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\CheckUserStatus;

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

        // Middleware global - akan dijalankan di setiap request yang authenticated
        app('router')->pushMiddlewareToGroup('web', CheckUserStatus::class);
    }
}
