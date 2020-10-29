<?php

namespace Naoray\LaravelPackageMaker\Commands\Database;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand as MakeMigration;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;
use Symfony\Component\Console\Input\InputOption;

class MigrationMakeCommand extends MakeMigration
{
    use CreatesPackageStubs, HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:migration';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = null;

    /**
     * Create a new migration install command instance.
     *
     * @param Illuminate\Filesystem\Filesystem                 $creator
     * @param \Illuminate\Database\Migrations\MigrationCreator $creator
     * @param \Illuminate\Support\Composer                     $composer
     */
    public function __construct(Filesystem $files, MigrationCreator $creator, Composer $composer)
    {
        parent::__construct($creator, $composer);

        $this->files = $files;
    }

    /**
     * Get migration path (either specified by '--path' option or default location).
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        $path = $this->basePath().'database/migrations';

        if (! is_null($targetPath = $this->input->getOption('path'))) {
            $path = ! $this->usingRealPath()
                ? $this->basePath().$targetPath
                : $targetPath;
        }

        return $path;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     *
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Adds additional options to the command.
     *
     * @return array
     */
    protected function additionalOptions()
    {
        return [
            ['create', null, InputOption::VALUE_REQUIRED, 'The table to be created'],
            ['table', null, InputOption::VALUE_REQUIRED, 'The table to migrate'],
            ['path', null, InputOption::VALUE_REQUIRED, 'The location where the migration file should be created'],
            ['realpath', null, InputOption::VALUE_NONE, 'Indicate any provided migration file paths are pre - resolved absolute paths'],
            ['fullpath', null, InputOption::VALUE_NONE, 'Output the full path of the migration'],
        ];
    }
}
