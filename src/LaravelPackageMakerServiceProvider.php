<?php

namespace Naoray\LaravelPackageMaker;

use Illuminate\Support\ServiceProvider;
use Naoray\LaravelPackageMaker\Commands\AddPackage;
<<<<<<< HEAD
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
=======
use Naoray\LaravelPackageMaker\Commands\PackageMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\JobMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\ReadmeMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\TravisMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\RuleMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\TestMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\MailMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\LicenseMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\StyleciMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\CodecovMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\PhpunitMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\BaseTestMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Database\FactoryMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\EventMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\ComposerMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\ModelMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\GitignoreMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\PolicyMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Database\MigrationMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Routing\ControllerMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\ProviderMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\ContributionMakeCommand;
>>>>>>> master

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
            RuleMakeCommand::class,
            EventMakeCommand::class,
            ModelMakeCommand::class,
            ReadmeMakeCommand::class,
            PolicyMakeCommand::class,
            TravisMakeCommand::class,
            PackageMakeCommand::class,
            StyleciMakeCommand::class,
            CodecovMakeCommand::class,
            FactoryMakeCommand::class,
            LicenseMakeCommand::class,
            PhpunitMakeCommand::class,
            ComposerMakeCommand::class,
            BaseTestMakeCommand::class,
            ProviderMakeCommand::class,
            GitignoreMakeCommand::class,
            MigrationMakeCommand::class,
            ControllerMakeCommand::class,
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
