<?php

namespace Naoray\LaravelPackageMaker\Commands\Foundation;

use Naoray\LaravelPackageMaker\Traits\HasNameInput;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Illuminate\Foundation\Console\ExceptionMakeCommand as MakeException;

class ExceptionMakeCommand extends MakeException
{
    use CreatesPackageStubs, HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:exception';

    /**
     * Get the destination class path.
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput().'/src';
    }
}
