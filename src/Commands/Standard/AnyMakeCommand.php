<?php

namespace Naoray\LaravelPackageMaker\Commands\Standard;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;
use Naoray\LaravelPackageMaker\Commands\GeneratorCommand;

class AnyMakeCommand extends GeneratorCommand
{
    use HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:any';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new file of custom type';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Any';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $this->type = ucfirst($this->getCategoryInput());

        parent::handle();

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        $this->callSilent('package:replace', [
            'path' => $path,
            '--old' => ['DummyType'],
            '--new' => [$this->getTypeInput()],
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
        return $rootNamespace.'\\'.str_plural(ucfirst(camel_case($this->getCategoryInput())));
    }

    /**
     * @return string
     */
    protected function getTypeInput()
    {
        return trim($this->option('type')) ?: 'class';
    }

    /**
     * @return string
     */
    protected function getCategoryInput()
    {
        return trim($this->option('category')) ?: 'service';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function additionalOptions()
    {
        return [
            ['category', 'c', InputOption::VALUE_OPTIONAL, 'The file\'s category/folder.'],

            ['type', 't', InputOption::VALUE_OPTIONAL, 'The file\'s type (interface, class, trait, abstract class)'],
        ];
    }
}
