<?php

namespace Naoray\LaravelPackageMaker;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\ServiceProvider;
use Naoray\LaravelPackageMaker\Commands\AddPackage;
use Naoray\LaravelPackageMaker\Commands\ClonePackage;
use Naoray\LaravelPackageMaker\Commands\Database\FactoryMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Database\MigrationMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Database\SeederMakeCommand;
use Naoray\LaravelPackageMaker\Commands\DeletePackageCredentials;
use Naoray\LaravelPackageMaker\Commands\Foundation\ChannelMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\ConsoleMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\EventMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\ExceptionMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\JobMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\ListenerMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\MailMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\ModelMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\NotificationMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\ObserverMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\PolicyMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\ProviderMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\RequestMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\ResourceMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\RuleMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Foundation\TestMakeCommand;
use Naoray\LaravelPackageMaker\Commands\NovaMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\BaseTestMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\CodecovMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\ComposerMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\ContributionMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\GitignoreMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\LicenseMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\PhpunitMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\ReadmeMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\StyleciMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Package\TravisMakeCommand;
use Naoray\LaravelPackageMaker\Commands\PackageMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Replace;
use Naoray\LaravelPackageMaker\Commands\Routing\ControllerMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Routing\MiddlewareMakeCommand;
use Naoray\LaravelPackageMaker\Commands\SavePackageCredentials;
use Naoray\LaravelPackageMaker\Commands\Standard\AnyMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Standard\ContractMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Standard\InterfaceMakeCommand;
use Naoray\LaravelPackageMaker\Commands\Standard\TraitMakeCommand;

class LaravelPackageMakerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(MigrationCreator::class)
            ->needs('$customStubPath')
            ->give(function ($app) {
                return $app->basePath('stubs');
            });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands(
            array_merge(
                $this->routingCommands(),
                $this->packageCommands(),
                $this->databaseCommands(),
                $this->standardCommands(),
                $this->foundationCommands(),
                $this->packageInternalCommands()
            )
        );
    }

    /**
     * Get package database related commands.
     *
     * @return array
     */
    protected function databaseCommands()
    {
        return [
            SeederMakeCommand::class,
            FactoryMakeCommand::class,
            MigrationMakeCommand::class,
        ];
    }

    /**
     * Get package foundation related commands.
     *
     * @return array
     */
    protected function foundationCommands()
    {
        return [
            JobMakeCommand::class,
            MailMakeCommand::class,
            TestMakeCommand::class,
            RuleMakeCommand::class,
            EventMakeCommand::class,
            ModelMakeCommand::class,
            PolicyMakeCommand::class,
            ConsoleMakeCommand::class,
            RequestMakeCommand::class,
            ChannelMakeCommand::class,
            ProviderMakeCommand::class,
            ListenerMakeCommand::class,
            ObserverMakeCommand::class,
            ResourceMakeCommand::class,
            ExceptionMakeCommand::class,
            NotificationMakeCommand::class,
        ];
    }

    /**
     * Get package related commands.
     *
     * @return array
     */
    protected function packageCommands()
    {
        return [
            NovaMakeCommand::class,
            ReadmeMakeCommand::class,
            TravisMakeCommand::class,
            LicenseMakeCommand::class,
            PhpunitMakeCommand::class,
            StyleciMakeCommand::class,
            CodecovMakeCommand::class,
            ComposerMakeCommand::class,
            BaseTestMakeCommand::class,
            GitignoreMakeCommand::class,
            ContributionMakeCommand::class,
        ];
    }

    /**
     * Get package internal related commands.
     *
     * @return array
     */
    protected function packageInternalCommands()
    {
        return [
            Replace::class,
            AddPackage::class,
            ClonePackage::class,
            PackageMakeCommand::class,
            SavePackageCredentials::class,
            DeletePackageCredentials::class,
        ];
    }

    /**
     * Get package routing related commands.
     *
     * @return array
     */
    protected function routingCommands()
    {
        return [
            ControllerMakeCommand::class,
            MiddlewareMakeCommand::class,
        ];
    }

    /**
     * Get standard related commands.
     *
     * @return array
     */
    protected function standardCommands()
    {
        return [
            AnyMakeCommand::class,
            TraitMakeCommand::class,
            ContractMakeCommand::class,
            InterfaceMakeCommand::class,
        ];
    }
}
