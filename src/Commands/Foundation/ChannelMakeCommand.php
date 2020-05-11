<?php

namespace Naoray\LaravelPackageMaker\Commands\Foundation;

use Illuminate\Foundation\Console\ChannelMakeCommand as MakeChannel;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;

class ChannelMakeCommand extends MakeChannel
{
    use CreatesPackageStubs, HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:channel';

    /**
     * Get the destination class path.
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput().'src';
    }
}
