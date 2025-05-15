<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ScryfallService;
class ScryfallServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(ScryfallService::class, function ($app) {
            return new ScryfallService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
