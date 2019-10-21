<?php

namespace Naoray\LaravelPackageMaker\Traits;

use Illuminate\Support\Str;
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
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->basePath().str_replace('\\', '/', $name).$this->getFileType();
    }

    /**
     * Get Packages base Path.
     *
     * @return string
     */
    protected function basePath()
    {
        return base_path().'/'.Str::finish($this->resolveDirectory(), '/');
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

        return $this->replacePackageName($class);
    }

    /**
     * Replace the dummy data with the package name for the given stub.
     *
     * @param string $stub
     *
     * @return string
     */
    protected function replacePackageName(&$stub)
    {
        return str_replace(
            ['DummyVendor', 'DummyPackageName'],
            [$this->vendorName(), $this->packageName()],
            $stub
        );
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->getNamespaceInput().'\\';
    }

    /**
     * Get vendor name.
     *
     * @return string
     */
    protected function vendorName()
    {
        return lcfirst(Str::before($this->getNamespaceInput(), '\\'));
    }

    /**
     * Get Package name.
     *
     * @return string
     */
    protected function packageName()
    {
        return Str::slug(Str::snake(Str::after($this->getNamespaceInput(), '\\')));
    }

    /**
     * Get the desired class namespace from the input.
     *
     * @return string
     */
    protected function getNamespaceInput()
    {
        $namespace = trim($this->option('namespace'));

        if (! $namespace && ! $namespace = cache()->get('package:namespace')) {
            $namespace = $this->ask('What is the namespace of your package?');
        }

        if (Str::contains($namespace, '\\')) {
            return $namespace;
        }

        $namespace = explode(
            '_',
            Str::snake(trim($this->option('namespace')))
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
        $dir = trim($this->option('dir'));

        if (! $dir && ! $dir = cache()->get('package:path')) {
            $dir = $this->ask('Where is your package stored (relative path)?');
        }

        return Str::endsWith($dir, '/') ? $dir : $dir.'/';
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
