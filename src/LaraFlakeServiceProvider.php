<?php

namespace Hafael\LaraFlake;

use Illuminate\Support\ServiceProvider;

class LaraFlakeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__ . '/config/laraflake.php' => config_path('laraflake.php')
        ]);
    }
}
