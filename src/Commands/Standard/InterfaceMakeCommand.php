<?php

namespace Naoray\LaravelPackageMaker\Commands\Standard;

use Illuminate\Console\Command;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;

class InterfaceMakeCommand extends Command
{
    use HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an interface';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('package:contract', [
            'name' => $this->argument('name'),
        ]);
    }
}
