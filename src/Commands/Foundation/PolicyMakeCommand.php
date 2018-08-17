<?php

namespace Naoray\LaravelPackageMaker\Commands\Foundation;

use Symfony\Component\Console\Input\InputOption;
use Naoray\LaravelPackageMaker\Traits\HasNameAttribute;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Illuminate\Foundation\Console\PolicyMakeCommand as MakePolicy;

class PolicyMakeCommand extends MakePolicy
{
	use CreatesPackageStubs, HasNameAttribute;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:package:policy';

	/**
	 * Get the destination class path.
	 *
	 * @return string
	 */
	protected function resolveDirectory()
	{
		return $this->getDirInput() . '/src';
	}

	/**
	 * Replace the model for the given stub.
	 *
	 * @param  string  $stub
	 * @param  string  $model
	 * @return string
	 */
	protected function replaceModel($stub, $model)
	{
		$model = str_replace('/', '\\', $model);

		$namespaceModel = $this->rootNamespace() . '\\' . $model;

		if (starts_with($model, '\\')) {
			$stub = str_replace('NamespacedDummyModel', trim($model, '\\'), $stub);
		} else {
			$stub = str_replace('NamespacedDummyModel', $namespaceModel, $stub);
		}

		$stub = str_replace(
			"use {$namespaceModel};\nuse {$namespaceModel};",
			"use {$namespaceModel};",
			$stub
		);

		$model = class_basename(trim($model, '\\'));

		$dummyUser = class_basename(config('auth.providers.users.model'));

		$dummyModel = camel_case($model) === 'user' ? 'model' : $model;

		$stub = str_replace('DocDummyModel', snake_case($dummyModel, ' '), $stub);

		$stub = str_replace('DummyModel', $model, $stub);

		$stub = str_replace('dummyModel', camel_case($dummyModel), $stub);

		$stub = str_replace('DummyUser', $dummyUser, $stub);

		return str_replace('DocDummyPluralModel', snake_case(str_plural($dummyModel), ' '), $stub);
	}
}
