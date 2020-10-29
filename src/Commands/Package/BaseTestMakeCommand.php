<?php

namespace Naoray\LaravelPackageMaker\Commands\Package;

use Naoray\LaravelPackageMaker\Commands\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class BaseTestMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:basetest';

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
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        parent::handle();

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        $this->callSilent('package:replace', [
            'path' => $path,
            '--old' => ['{{ serviceProvider }}'],
            '--new' => [$this->getProviderInput()],
        ]);
    }

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
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput().'tests';
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
