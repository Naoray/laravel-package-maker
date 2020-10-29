<?php

namespace Naoray\LaravelPackageMaker\Commands\Package;

use Naoray\LaravelPackageMaker\Commands\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ReadmeMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:readme';

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
            '--old' => ['DummyAuthorEmail', 'DummyAuthor'],
            '--new' => [$this->getEmailInput(), $this->getAuthorInput()],
        ]);
    }

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

    /**
     * Get the author name from the input.
     *
     * @return string
     */
    protected function getAuthorInput()
    {
        return trim($this->option('author'));
    }

    /**
     * Get the author name from the input.
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
                ['author', 'A', InputOption::VALUE_REQUIRED, 'The author of this package'],
                ['email', 'E', InputOption::VALUE_REQUIRED, 'The email of the package author'],
            ]
        );
    }
}
