<?php

namespace Naoray\LaravelPackageMaker\Commands\Package;

class StyleciMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:styleci';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new .styleci file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'styleci';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/.styleci.stub';
    }

    /**
     * Get the stub file type for the generator.
     *
     * @return string
     */
    public function getFileType()
    {
        return '.yml';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return '.styleci';
    }
}
