<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // ✅ Add this line

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // if (config('app.env') === 'local' || config('app.env') === 'production') {
        //     URL::forceScheme('https');
        // }
    }
}
