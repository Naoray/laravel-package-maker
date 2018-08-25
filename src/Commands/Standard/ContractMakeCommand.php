<?php

namespace Naoray\LaravelPackageMaker\Commands\Standard;

use Illuminate\Console\Command;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;
use Naoray\LaravelPackageMaker\Commands\GeneratorCommand;

class ContractMakeCommand extends GeneratorCommand
{
    use HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contract';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Contract';

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
            '--old' => ['DummyType'],
            '--new' => ['interface'],
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/dummy.stub';
    }

    /**
     * Get the destination class path.
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput().'src';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Contracts';
    }
}
