<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

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
        Sanctum::authenticateAccessTokensUsing(
            static function (PersonalAccessToken $accessToken, bool $is_valid) {
                $expiration = $accessToken->name == 'access' ? config('sanctum.expiration') : config('sanctum.rt_expiration');

                return $accessToken->created_at ? $accessToken->created_at->gt(now()->subMinutes($expiration)) : false;
            }
        );
    }
}
