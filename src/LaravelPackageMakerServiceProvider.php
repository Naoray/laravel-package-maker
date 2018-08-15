<?php

namespace Naoray\LaravelPackageMaker;

use Illuminate\Support\ServiceProvider;
use Naoray\LaravelPackageMaker\Commands\AddPackage;
use Naoray\LaravelPackageMaker\Commands\BaseTestMakeCommand;
use Naoray\LaravelPackageMaker\Commands\ComposerMakeCommand;
use Naoray\LaravelPackageMaker\Commands\ContributionMakeCommand;
use Naoray\LaravelPackageMaker\Commands\GitignoreMakeCommand;
use Naoray\LaravelPackageMaker\Commands\LicenseMakeCommand;
use Naoray\LaravelPackageMaker\Commands\PackageMakeCommand;
use Naoray\LaravelPackageMaker\Commands\PhpunitMakeCommand;
use Naoray\LaravelPackageMaker\Commands\ProviderMakeCommand;
use Naoray\LaravelPackageMaker\Commands\ReadmeMakeCommand;
use Naoray\LaravelPackageMaker\Commands\StyleciMakeCommand;
use Naoray\LaravelPackageMaker\Commands\TestMakeCommand;
use Naoray\LaravelPackageMaker\Commands\TravisMakeCommand;

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
            TestMakeCommand::class,
            TravisMakeCommand::class,
            ReadmeMakeCommand::class,
            StyleciMakeCommand::class,
            LicenseMakeCommand::class,
            PhpunitMakeCommand::class,
            PackageMakeCommand::class,
            ProviderMakeCommand::class,
            BaseTestMakeCommand::class,
            ComposerMakeCommand::class,
            GitignoreMakeCommand::class,
            ContributionMakeCommand::class,
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
