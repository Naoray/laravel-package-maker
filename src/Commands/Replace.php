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
                                {path : The path to a file or directory}
                                {--O|old=* : Old strings which will be replaced}
                                {--N|new=* : New strings which will be used as replacement}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replaces all old inputs with new ones.';

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

        if ($this->files->isDirectory($path = $this->getPathInput())) {
            collect($this->files->allFiles($path))
                ->each(function ($file) {
                    $this->buildFile($file->getPathName());
                }
            );
        }

        if ($this->files->isFile($path)) {
            $this->buildFile($path);
        }

        $this->info('All old inputs got replaced!');
    }

    /**
     * Builds the new file.
     *
     * @param string $path
     * @return void
     */
    public function buildFile($path)
    {
        $this->files->put($path, $this->replaceContents($path));
        $this->renameFile($path);
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
     * Get path directory.
     *
     * @return string
     */
    public function getPathInput()
    {
        return trim($this->argument('path'));
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
