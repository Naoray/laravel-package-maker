<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Symfony\Component\Console\Input\InputOption;

class LicenseMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:package:license';

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
     * Replace the names for the given stub.
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceOthers(&$stub, $name)
    {
        $class = parent::replaceOthers($stub, $name);

        return str_replace(
            ['CompanyOrVendorName'],
            [$this->getCopyrightInput()],
            $class
        );
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
