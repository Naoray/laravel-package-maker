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
                                {--O|old=* : Old strings which will be replaced}
                                {--N|new=* : New strings which will be used as replacement}';

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
        if ($this->getOldInput()->count() !== $this->getNewInput()->count()) {
            return $this->error('Old and new options need to have the same length!');
        }

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
        return str_replace(
            $this->getOldInput()->toArray(),
            $this->getNewInput()->toArray(),
            $stub
        );
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
        return collect($this->option('old'));
    }

    /**
     * Get new namespace.
     *
     * @return string
     */
    public function getNewInput()
    {
        return collect($this->option('new'));
    }
}
