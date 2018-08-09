<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;

class AddPackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:add {name?} {path?} {vendor?} {branch?} {--type=path} {--without-interaction}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds local package with repository option.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->argument('path');
        $vendor = $this->argument('vendor');
        $branch = $this->argument('branch');
        $type = $this->option('type');

        if ($name && str_contains($name, '/')) {
            $vendor = str_before($name, '/');
            $name = str_after($name, '/');
        }

        if (!$vendor) {
            $vendor = $this->ask('What is your package\'s vendor name?');
        }

        if (!$name) {
            $name = $this->ask('What is your package\'s name?');
        }

        if (!$path) {
            $path = $this->anticipate('What is your package\'s path?', ['../packages/'.$name]);
        }

        if (!$branch) {
            $branch = $this->anticipate('What branch do you want to link?', ['dev', 'master']);
        }

        $this->table(['vendor', 'name', 'path', 'branch', 'type'], [[$vendor, $name, $path, $branch, $type]]);
        if (!$this->option('without-interaction') && !$this->confirm('Do you wish to continue?')) {
            return;
        }

        if ($branch === 'dev' || $branch === 'master') {
            $branch = 'dev-'.$branch;
        }

        exec('composer config repositories.'.$name.' '.$type.' '.$path);
        sleep(1);
        exec('composer require "'.$vendor.'/'.$name.':'.$branch.'"');
    }
}
