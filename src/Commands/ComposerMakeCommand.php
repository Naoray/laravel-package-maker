<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Symfony\Component\Console\Input\InputOption;

class ComposerMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:package:composer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new composer file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'composer';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/composer.stub';
    }

    /**
     * Get the stub file type for the generator.
     *
     * @return string
     */
    public function getFileType()
    {
        return '.json';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return 'composer';
	}

	/**
     * Replace the names for the given stub.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceStubSpecifics(&$stub, $name)
    {
        return str_replace(
            ['DummyAuthor', 'DummyEmail', 'DummyComposerNamespace', 'DummyComposerProviderNamespace'],
            [$this->getAuthorInput(), $this->getEmailInput(), $this->composerNamespace(), $this->composerProviderNamespace()],
            $stub
        );
    }

    /**
     * @return string
     */
    protected function composerNamespace()
    {
        return ucfirst($this->vendorName()) . '\\\\' . ucfirst($this->packageName()) . '\\\\';
    }

    /**
     * @return string
     */
    protected function composerProviderNamespace()
    {
        return $this->composerNamespace() . ucfirst($this->packageName()) . 'ServiceProvider';
    }

    /**
     * Get the desired author from the input.
     *
     * @return string
     */
    protected function getAuthorInput()
    {
        return trim($this->option('author'));
    }

    /**
     * Get the desired email from the input.
     *
     * @return string
     */
    protected function getEmailInput()
    {
        return trim($this->option('email'));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(
            parent::getOptions(),
            [
                ['author', 'A', InputOption::VALUE_REQUIRED, 'The author of the package.'],

                ['email', 'E', InputOption::VALUE_REQUIRED, 'The author\'s email.'],
            ]
        );
    }
}
