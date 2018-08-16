<?php

namespace Naoray\LaravelPackageMaker;

use Illuminate\Support\ServiceProvider;
use Naoray\LaravelPackageMaker\Commands\AddPackage;
use Naoray\LaravelPackageMaker\Commands\JobMakeCommand;
use Naoray\LaravelPackageMaker\Commands\MailMakeCommand;
use Naoray\LaravelPackageMaker\Commands\TestMakeCommand;
use Naoray\LaravelPackageMaker\Commands\ReadmeMakeCommand;
use Naoray\LaravelPackageMaker\Commands\TravisMakeCommand;
use Naoray\LaravelPackageMaker\Commands\CodecovMakeCommand;
use Naoray\LaravelPackageMaker\Commands\LicenseMakeCommand;
use Naoray\LaravelPackageMaker\Commands\PackageMakeCommand;
use Naoray\LaravelPackageMaker\Commands\PhpunitMakeCommand;
use Naoray\LaravelPackageMaker\Commands\StyleciMakeCommand;
use Naoray\LaravelPackageMaker\Commands\BaseTestMakeCommand;
use Naoray\LaravelPackageMaker\Commands\ComposerMakeCommand;
use Naoray\LaravelPackageMaker\Commands\ProviderMakeCommand;
use Naoray\LaravelPackageMaker\Commands\GitignoreMakeCommand;
use Naoray\LaravelPackageMaker\Commands\ContributionMakeCommand;

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
            JobMakeCommand::class,
            TestMakeCommand::class,
            MailMakeCommand::class,
            ReadmeMakeCommand::class,
            TravisMakeCommand::class,
            CodecovMakeCommand::class,
            LicenseMakeCommand::class,
            PhpunitMakeCommand::class,
            StyleciMakeCommand::class,
            PackageMakeCommand::class,
            ComposerMakeCommand::class,
            ProviderMakeCommand::class,
            BaseTestMakeCommand::class,
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
