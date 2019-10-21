<?php

namespace Naoray\LaravelPackageMaker\Commands\Foundation;

use Illuminate\Support\Str;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Illuminate\Foundation\Console\ModelMakeCommand as MakeModel;

class ModelMakeCommand extends MakeModel
{
    use CreatesPackageStubs, HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:model';

    /**
     * Get the destination class path.
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput() . 'src';
    }

    /**
     * Create a model factory for the model.
     */
    protected function createFactory()
    {
        $factory = Str::studly(class_basename($this->argument('name')));

        $this->call('package:factory', [
            'name' => "{$factory}Factory",
            '--model' => $this->argument('name'),
            '--namespace' => $this->getNamespaceInput(),
            '--dir' => $this->getDirInput(),
        ]);
    }

    /**
     * Create a migration file for the model.
     */
    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        $this->call('package:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
            '--namespace' => $this->getNamespaceInput(),
            '--dir' => $this->getDirInput(),
        ]);
    }

    /**
     * Create a controller for the model.
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('package:controller', [
            'name' => "{$controller}Controller",
            '--model' => $this->option('resource') ? $modelName : null,
            '--namespace' => $this->getNamespaceInput(),
            '--dir' => $this->getDirInput(),
        ]);
    }
}
