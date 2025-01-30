<?php

namespace DevDizs\PayappWs;

use Illuminate\Support\ServiceProvider;

class PayappWsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Merge the package configuration with the application's published configuration.
        $this->mergeConfigFrom(
            __DIR__.'/../config/payappws.php', 'payappws-config'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Publish the configuration file.
        $this->publishes([
            __DIR__.'/../config/payappws.php' => config_path('payappws.php'),
        ], 'config'); // Use 'config' as the tag for publishing.
    }
}