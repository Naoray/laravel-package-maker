<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Naoray\LaravelPackageMaker\Traits\InteractsWithTerminal;

class ClonePackage extends Command
{
    use InteractsWithTerminal;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:clone
                                {src : Source path of the package to clone}
                                {target : Path where it should be cloned in}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clone a package to start building your own.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
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
        if ($this->files->isDirectory($target = $this->getTargetInput())) {
            $this->error($target.' directory already exists!');
        }

        if ($this->srcIsRemote()) {
            return $this->gitClone();
        }

        $this->localClone();
    }

    /**
     * Clone local package.
     */
    public function localClone()
    {
        $successfull = $this->files->copyDirectory($this->getSrcInput(), $this->getTargetInput());

        if (! $successfull) {
            $this->error('Copying was not successfull!');
        }

        if ($this->files->isDirectory($vendor = $this->getTargetInput().'/vendor')) {
            $this->files->deleteDirectory($vendor);

            $this->info('Removed vendor folder.');
        }

        $this->info('Cloning was successful!');
    }

    /**
     * Clone package via git.
     */
    public function gitClone()
    {
        $this->runConsoleCommand('git clone '.$this->argument('src').' '.$this->argument('target'), getcwd());

        if ($this->files->isDirectory($git = $this->getTargetInput().'/.git')) {
            $this->files->deleteDirectory($git);

            $this->info('Removed .git folder.');
        }
    }

    /**
     * Checks if source is remote.
     *
     * @return bool
     */
    public function srcIsRemote()
    {
        return Str::contains($this->getSrcInput(), ['https', 'git@']);
    }

    /**
     * Get the src path.
     *
     * @return string
     */
    public function getSrcInput()
    {
        return trim($this->argument('src'));
    }

    /**
     * Get the target path.
     *
     * @return string
     */
    public function getTargetInput()
    {
        return trim($this->argument('target'));
    }
}
