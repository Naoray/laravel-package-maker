<?php

namespace Naoray\LaravelPackageMaker\Commands\Package;

use Naoray\LaravelPackageMaker\Commands\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class LicenseMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:license';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new license guide';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'license';

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
            '--old' => ['{{ year }}', '{{ companyOrVendor }}'],
            '--new' => [date('Y'), $this->getCopyrightInput()],
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/LICENSE.stub';
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
        return 'LICENSE';
    }

    /**
     * Get the desired copyright from the input.
     *
     * @return string
     */
    protected function getCopyrightInput()
    {
        return trim($this->option('copyright'));
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
                ['copyright', 'C', InputOption::VALUE_REQUIRED, 'The company or vendor name to place it int the license file'],
            ]
        );
    }
}
