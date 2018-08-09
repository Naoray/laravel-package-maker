<?php

namespace Naoray\LaravelPackageMaker;

use Illuminate\Support\ServiceProvider;
use Naoray\LaravelPackageMaker\Commands\AddPackage;
use Naoray\LaravelPackageMaker\Commands\MakePackage;

class LaravelPackageMakerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            AddPackage::class,
            MakePackage::class,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
