<?php

namespace Naoray\LaravelPackageMaker\Commands\Foundation;

use Symfony\Component\Console\Input\InputOption;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Illuminate\Foundation\Console\TestMakeCommand as MakeTest;

class TestMakeCommand extends MakeTest
{
    use CreatesPackageStubs, HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:test';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = null;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('unit')) {
            return __DIR__.'/stubs/unit-test.stub';
        }

        return __DIR__.'/stubs/test.stub';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->getNamespaceInput().'\Tests';
    }

    /**
     * Get the destination class path.
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput().'/tests';
    }

    /**
     * Adds additional options to the command.
     *
     * @return array
     */
    protected function additionalOptions()
    {
        return [
            ['unit', 'u', InputOption::VALUE_NONE, 'Create a unit test'],
        ];
    }
}
