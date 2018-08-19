<?php

namespace Naoray\LaravelPackageMaker\Traits;

use Symfony\Component\Console\Input\InputOption;

trait CreatesPackageStubs
{
    /**
     * Get the stub file type for the generator.
     *
     * @return string
     */
    public function getFileType()
    {
        return '.php';
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->rootNamespace(), '', $name);

        return $this->basePath().str_replace('\\', '/', $name).$this->getFileType();
    }

    /**
     * Get Packages base Path.
     *
     * @return string
     */
    protected function basePath()
    {
        return base_path().'/'.$this->resolveDirectory();
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        return $this->replacePackageName($class)->replaceStubSpecifics($class, $name);
    }

    /**
     * Replace the dummy data with the package name for the given stub.
     *
     * @param string $stub
     *
     * @return \Naoray\LaravelPackageMaker\Traits\CreatsPackageStubs
     */
    protected function replacePackageName(&$stub)
    {
        $stub = str_replace(
            ['DummyVendor', 'DummyPackageName'],
            [$this->vendorName(), $this->packageName()],
            $stub
        );

        return $this;
    }

    /**
     * Replace the dummy data for the given stub.
     *
     * @param string $stub
     *
     * @return \Naoray\LaravelPackageMaker\Traits\CreatePackageStubs
     */
    protected function replaceStubSpecifics(&$stub, $name)
    {
        return $stub;
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->getNamespaceInput();
    }

    /**
     * Get vendor name.
     *
     * @return string
     */
    protected function vendorName()
    {
        return lcfirst(str_before($this->getNamespaceInput(), '\\'));
    }

    /**
     * Get Package name.
     *
     * @return string
     */
    protected function packageName()
    {
        return lcfirst(str_after($this->getNamespaceInput(), '\\'));
    }

    /**
     * Get the desired class namespace from the input.
     *
     * @return string
     */
    protected function getNamespaceInput()
    {
        $namespace = trim($this->option('namespace'));

        if (str_contains($namespace, '\\')) {
            return $namespace;
        }

        $namespace = explode(
            '_',
            snake_case(trim($this->option('namespace')))
        );

        return implode('\\', array_map('ucfirst', $namespace));
    }

    /**
     * Get the desired directory from the input.
     *
     * @return string
     */
    protected function getDirInput()
    {
        return trim(
            ends_with($this->option('dir'), '/') ? $this->option('dir') : $this->option('dir').'/'
        );
    }

    /**
     * Resolve directory where stub will be created.
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput();
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
                ['namespace', 'N', InputOption::VALUE_REQUIRED, 'The namespace in which the file will be created'],

                ['dir', 'D', InputOption::VALUE_REQUIRED, 'Directory where the package will be stored'],
            ],
            $this->additionalOptions()
        );
    }

    /**
     * Adds additional options to the command.
     *
     * @return array
     */
    protected function additionalOptions()
    {
        return [];
    }
}
