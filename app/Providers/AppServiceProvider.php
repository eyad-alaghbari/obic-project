<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;

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
        RateLimiter::for('api', function (Request $request) {
            $user = $request->user();
            $limit = $user instanceof User ? 60 : 30;

            $identifier = $user ? $user->id : $request->ip();

            return Limit::perMinute($limit)->by($identifier);
        });
    }
}
