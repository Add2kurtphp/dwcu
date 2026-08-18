<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Railway (and most platform hosts) terminate HTTPS at their edge and
        // forward requests to the app over plain HTTP, so Laravel doesn't see
        // the request as secure and generates http:// asset/route URLs —
        // which browsers block as mixed content on an https:// page.
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
