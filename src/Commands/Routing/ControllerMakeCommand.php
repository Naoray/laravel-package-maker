<?php

namespace Naoray\LaravelPackageMaker\Commands\Routing;

use Illuminate\Routing\Console\ControllerMakeCommand as MakeController;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;

class ControllerMakeCommand extends MakeController
{
    use CreatesPackageStubs, HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:controller';

    /**
     * Get the destination class path.
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput().'src';
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

        if (Str::contains($class, $this->rootNamespace().'Http\Controllers\Controller')) {
            return str_replace(
                $this->rootNamespace().'Http\Controllers\Controller',
                'Illuminate\Routing\Controller',
                $class
            );
        }

        return str_replace(
            'use Illuminate\Http\Request;',
            "use Illuminate\Http\Request;\nuse Illuminate\Routing\Controller;",
            $class
        );
    }

    /**
     * Build the replacements for a parent controller.
     *
     * @return array
     */
    protected function buildParentReplacements()
    {
        $parentModelClass = $this->parseModel($this->option('parent'));

        if (! class_exists($parentModelClass)) {
            if ($this->confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('package:model', [
                    'name' => $parentModelClass,
                    '--namespace' => $this->rootNamespace(),
                    '--dir' => $this->basePath(),
                ]);
            }
        }

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    /**
     * Build the model replacement values.
     *
     * @param array $replace
     *
     * @return array
     */
    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel($this->option('model'));

        if (! class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('package:model', [
                    'name' => $modelClass,
                    '--namespace' => $this->rootNamespace(),
                    '--dir' => $this->basePath(),
                ]);
            }
        }

        array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param string $model
     *
     * @return string
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith($model, $rootNamespace = $this->rootNamespace()) && ! Str::startsWith($model, $this->laravel->getNamespace())) {
            $model = $rootNamespace.'\\'.$model;
        }

        return $model;
    }
}
