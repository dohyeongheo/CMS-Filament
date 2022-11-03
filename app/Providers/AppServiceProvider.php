<?php

namespace App\Providers;

// use Filament\Notifications\Notification;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Notification::configureUsing(function (Notification $notification): void {
        //     $notification->view('notifications.notification');
        // });

        Filament::serving(function () {
            // Using Vite
            Filament::registerTheme(
                app(Vite::class)('resources/css/filament.css'),
            );
        });
    }
}
