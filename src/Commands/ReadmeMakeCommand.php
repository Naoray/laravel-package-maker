<?php

namespace Naoray\LaravelPackageMaker\Commands;

class ReadmeMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:package:readme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new readme file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
	protected $type = 'readme';
	
	/**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/readme.stub';
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
        return 'readme';
    }
}
