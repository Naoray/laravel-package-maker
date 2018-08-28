<?php

namespace Naoray\LaravelPackageMaker\Commands\Standard;

use Illuminate\Console\Command;
use Naoray\LaravelPackageMaker\Traits\HasNameInput;

class ContractMakeCommand extends Command
{
    use HasNameInput;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new contract';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Contract';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $this->callSilent('package:any', [
            'name' => $this->argument('name'),
            '--type' => 'interface',
            '--category' => $this->type,
        ]);
    }
}
