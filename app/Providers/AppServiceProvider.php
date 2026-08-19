<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
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
        if (
            app()->environment('production') ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            request()->header('x-forwarded-proto') === 'https' ||
            (!in_array(request()->getHost(), ['127.0.0.1', 'localhost']) && !app()->isLocal())
        ) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }

        Vite::createAssetPathsUsing(function (string $path, ?bool $secure = null) {
            return '/' . ltrim($path, '/');
        });
    }
}

