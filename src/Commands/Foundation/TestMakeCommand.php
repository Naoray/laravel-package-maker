<?php

namespace Naoray\LaravelPackageMaker\Commands\Foundation;

use Illuminate\Foundation\Console\TestMakeCommand as MakeTest;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;
use Symfony\Component\Console\Input\InputOption;

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
        return $this->option('unit')
                    ? $this->resolveStubPath('/stubs/test.unit.stub')
                    : $this->resolveStubPath('/stubs/test.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = base_path(trim($stub, '/')))
                        ? $customPath
                        : __DIR__.$stub;
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
