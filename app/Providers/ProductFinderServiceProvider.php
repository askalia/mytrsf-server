<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ProductFinderServiceProvider extends ServiceProvider
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
        $this->app->bind('ProductFinder', function()
        {
            return new \App\ProductFinder\Finder();
        });
    }
}
