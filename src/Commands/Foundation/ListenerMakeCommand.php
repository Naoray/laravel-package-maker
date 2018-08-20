<?php

namespace Naoray\LaravelPackageMaker\Commands\Foundation;

use Naoray\LaravelPackageMaker\Traits\HasNameAttribute;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Illuminate\Foundation\Console\ListenerMakeCommand as MakeListener;

class ListenerMakeCommand extends MakeListener
{
    use CreatesPackageStubs, HasNameAttribute;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:package:listener';

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
