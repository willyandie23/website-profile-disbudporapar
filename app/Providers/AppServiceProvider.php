<?php

namespace App\Providers;

use routes;
// use Laravel\Passport\Passport;
use App\Traits\ModelLog;
use Laravel\Passport\Passport;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
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
        // Tangkap event login
        Event::listen(Login::class, function ($event) {
            ModelLog::storeAuthLog('LOGIN');
        });

        // Tangkap event logout
        Event::listen(Logout::class, function ($event) {
            ModelLog::storeAuthLog('LOGOUT');
        });
    }
}
