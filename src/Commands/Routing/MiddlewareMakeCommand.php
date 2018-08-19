<?php

namespace Naoray\LaravelPackageMaker\Commands\Routing;

use Naoray\LaravelPackageMaker\Traits\HasNameAttribute;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Illuminate\Routing\Console\MiddlewareMakeCommand as MakeMiddleware;

class MiddlewareMakeCommand extends MakeMiddleware
{
	use CreatesPackageStubs, HasNameAttribute;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:package:middleware';

	/**
	 * Get the destination class path.
	 *
	 * @return string
	 */
	protected function resolveDirectory()
	{
		return $this->getDirInput() . 'src';
	}
}
