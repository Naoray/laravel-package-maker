<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Symfony\Component\Console\Input\InputArgument;

class BaseTestMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:package:basetest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new testbase file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Testbase';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/base-test.stub';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return 'TestCase';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput().'/tests';
    }

    /**
     * Replace the names for the given stub.
     *
     * @param string $stub
     *
     * @return \Naoray\LaravelPackageMaker\Commands\BaseTestMakeCommand
     */
    protected function replaceStubSpecifics(&$stub, $name)
    {
        return str_replace(
            ['DummyPackageServiceProvider'],
            [$this->getProviderInput()],
            $stub
        );
    }

    /**
     * @return string
     */
    protected function getProviderInput()
    {
        return trim($this->argument('provider'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['provider', InputArgument::REQUIRED, 'The package\'s provider name'],
        ];
    }
}
