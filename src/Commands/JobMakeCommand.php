<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Naoray\LaravelPackageMaker\Traits\HasNameAttribute;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Illuminate\Foundation\Console\JobMakeCommand as MakeJob;

class JobMakeCommand extends MakeJob
{
	use CreatesPackageStubs, HasNameAttribute;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:package:job';

	/**
	 * Get the destination class path.
	 *
	 * @return string
	 */
	protected function resolveDirectory()
	{
		return $this->getDirInput() . '/src';
	}
}