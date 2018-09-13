<?php

namespace Naoray\LaravelPackageMaker\Commands\Package;

use Naoray\LaravelPackageMaker\Commands\GeneratorCommand;

class ContributionMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:contribution';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contribution guide';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'contribution';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/CONTRIBUTING.stub';
    }

    /**
     * Get the stub file type for the generator.
     *
     * @return string
     */
    public function getFileType()
    {
        return '.md';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return 'CONTRIBUTING';
    }
}
