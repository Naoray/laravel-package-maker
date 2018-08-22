<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ClonePackage extends Command
{
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
        if ($this->files->isDirectory($this->getTargetInput())) {
            $this->error($this->getTargetInput().' directory already exists!');
        }

        if ($this->srcIsRemote()) {
            return $this->gitClone();
        }

        $this->files->copyDirectory($this->getSrcInput(), $this->getTargetInput());
        $this->info('Cloning was successful!');
    }
    
    /**
     * Clone package via git.
     *
     * @return string
     */
    public function gitClone()
    {
        exec('git clone ' . $this->argument('src') . ' ' . $this->argument('target'));
    }

    /**
     * Checks if source is remote.
     * 
     * @return bool
     */
    public function srcIsRemote()
    {
        return str_contains($this->getSrcInput(), 'https');
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
