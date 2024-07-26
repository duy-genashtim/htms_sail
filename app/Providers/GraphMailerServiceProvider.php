<?php

namespace App\Providers;

use App\Services\GraphMailer;
use Illuminate\Support\ServiceProvider;

class GraphMailerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
        $this->app->singleton(GraphMailer::class, function ($app) {
            return new GraphMailer();
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
