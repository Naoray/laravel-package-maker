<?php

namespace Naoray\LaravelPackageMaker\Commands\Standard;

use Illuminate\Console\Command;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;

class TraitMakeCommand extends Command
{
    use HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Trait';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $this->callSilent('package:any', [
            'name' => $this->argument('name'),
            '--type' => 'trait',
            '--category' => $this->type,
        ]);
    }
}
