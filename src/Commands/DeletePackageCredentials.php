<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;

class DeletePackageCredentials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all package\'s credentials from the cache.';

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
        cache()->forget('package:namespace');
        cache()->forget('package:path');
    }
}
