<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class Replace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:replace 
                                {package : The package directory}
                                {old : Old Namespace which will be replaced}
                                {new : New Namespace which will be used as replacement}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replaces the namspace of a package';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        collect($this->files->allFiles($this->getPackageInput()))
            ->each(function ($file) {
                $path = $file->getPathName();

                $this->files->put($path, $this->replaceContents($path));
                $this->renameFile($path);
            }
        );
        
        $this->info('All old inputs got replaced!');
    }

    /**
     * Replace old contents.
     * 
     * @param string $path
     * @return string
     */
    protected function replaceContents($path)
    {
        $stub = $this->files->get($path);

        return $this->replaceAll($stub);
    }

    /**
     * Rename file.
     * 
     * @param string $path
     * @return void
     */
    protected function renameFile($path)
    {
        $newPath = $this->replaceAll($path);

        if ($newPath !== $path) {
            $this->files->move($path, $newPath);
        }
    }

    /**
     * Replace all occurrenes of old values with new ones.
     * 
     * @param string $stub
     * @return string
     */
    protected function replaceAll($stub)
    {
        return $this->replaceNamespace($stub)->replaceNames($stub);
    }

    /**
     * Replace old with new namespace.
     * 
     * @param string $stub
     * @return $this
     */
    protected function replaceNamespace(&$stub)
    {
        $stub = str_replace(
            [$this->namespaceVendor('old'), $this->namespacePackageName('old')],
            [$this->namespaceVendor('new'), $this->namespacePackageName('new')],
            $stub
        );

        return $this;
    }

    /**
     * Replace old with new names.
     *
     * @param string $stub
     * @return string
     */
    protected function replaceNames(&$stub)
    {
        return str_replace(
            [$this->vendorName('old'), $this->packageName('old')],
            [$this->vendorName('new'), $this->packageName('new')],
            $stub
        );
    }

    /**
     * Get packages namespace vendor.
     *
     * @param string $name
     * @return string
     */
    protected function namespaceVendor($name)
    {
        return str_before($this->splitNamespace($name), '\\');
    }

    /**
     * Get packages namespace name.
     * 
     * @param string $name
     * @return string
     */
    protected function namespacePackageName($name)
    {
        return str_after($this->splitNamespace($name), '\\');
    }

    /**
     * Get vendor name.
     *
     * @return string
     */
    protected function vendorName($name)
    {
        return lcfirst($this->namespaceVendor($name));
    }

    /**
     * Get Package name.
     *
     * @return string
     */
    protected function packageName($name)
    {
        return str_slug(snake_case($this->namespacePackageName($name)));
    }

    /**
     * Get the desired class namespace from the input.
     *
     * @return string
     */
    protected function splitNamespace($name)
    {
        $namespace = trim($this->{'get'.ucfirst($name).'Input'}($name));

        if (! $namespace && ! $namespace = cache()->get('package:namespace')) {
            $namespace = $this->ask('What is the namespace of your package?');
        }

        if (str_contains($namespace, '\\')) {
            return $namespace;
        }

        $namespace = explode(
            '_',
            snake_case($this->{'get'.ucfirst($name).'Input'}($name))
        );

        return implode('\\', array_map('ucfirst', $namespace));
    }

    /**
     * Get package directory.
     * 
     * @return string
     */
    public function getPackageInput()
    {
        return trim($this->argument('package'));
    }

    /**
     * Get old namespace.
     *
     * @return string
     */
    public function getOldInput()
    {
        return trim($this->argument('old'));
    }

    /**
     * Get new namespace.
     *
     * @return string
     */
    public function getNewInput()
    {
        return trim($this->argument('new'));
    }
}
