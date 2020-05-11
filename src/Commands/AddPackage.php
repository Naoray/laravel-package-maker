<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Naoray\LaravelPackageMaker\Traits\InteractsWithTerminal;

class AddPackage extends Command
{
    use InteractsWithTerminal;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:add {name?} {path?} {vendor?} {branch?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds local package with repository option.';

    /**
     * Package name.
     *
     * @var string
     */
    protected $packageName;

    /**
     * Package vendor name.
     *
     * @var string
     */
    protected $vendor;

    /**
     * Relative path to the package.
     *
     * @var string
     */
    protected $path;

    /**
     * Branch to add.
     *
     * @var string
     */
    protected $branch;

    /**
     * Create a new command instance.
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
        $this->checkForInputs();

        $this->addPackageRepositoryToRootComposer();
        $this->addPackageToRootComposer();
        $this->updateComposer();

        $this->call('package:save', [
            'namespace' => ucfirst($this->vendor).'\\'.ucfirst(Str::camel($this->packageName)),
            'path' => $this->path,
        ]);
    }

    /**
     * Update composer dependencies.
     */
    public function updateComposer()
    {
        $this->runConsoleCommand('composer update', getcwd());
    }

    /**
     * Add a path repository for the tool to the application's composer.json file.
     */
    protected function addPackageRepositoryToRootComposer()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        $composer['repositories'][$this->packageName] = [
            'type' => 'path',
            'url' => $this->path,
        ];

        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * Add a package entry for the tool to the application's composer.json file.
     */
    protected function addPackageToRootComposer()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        $composer['require'][$this->vendor.'/'.$this->packageName] = '*';

        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    /**
     * Checks for needed input and prints it out.
     */
    public function checkForInputs()
    {
        $name = $this->getNameInput();

        if ($name && Str::contains($name, '/')) {
            $this->vendor = Str::before($name, '/');
            $this->name = Str::after($name, '/');
        }

        $vendor = $this->getVendorInput();
        $path = $this->getPathInput();
        $branch = $this->getBranchInput();

        $this->table(['vendor', 'name', 'path', 'branch'], [[$vendor, $name, $path, $branch]]);
        if (! $this->option('no-interaction') && ! $this->confirm('Do you wish to continue?')) {
            return;
        }
    }

    /**
     * Get the package name from the input.
     *
     * @return string
     */
    public function getNameInput()
    {
        if ($this->packageName) {
            return $this->packageName;
        }

        if (! $this->packageName = trim($this->argument('name'))) {
            $this->packageName = $this->ask('What is your package\'s name?');
        }

        return $this->packageName;
    }

    /**
     * Get the vendor name from the input.
     *
     * @return string
     */
    public function getVendorInput()
    {
        if ($this->vendor) {
            return $this->vendor;
        }

        if (! $this->vendor = trim($this->argument('vendor'))) {
            $this->vendor = $this->ask('What is your package\'s vendor name?');
        }

        return $this->vendor;
    }

    /**
     * Get the path name from the input.
     *
     * @return string
     */
    public function getPathInput()
    {
        if ($this->path) {
            return $this->path;
        }

        if (! $this->path = trim($this->argument('path'))) {
            $this->path = $this->anticipate('What is your package\'s path?', [
                '../packages/'.$this->packageName, 'packages/'.$this->packageName,
            ]);
        }

        return $this->path;
    }

    /**
     * Get the branch name from the input.
     *
     * @return string
     */
    public function getBranchInput()
    {
        if ($this->branch) {
            return $this->branch;
        }

        if (! $this->branch = trim($this->argument('branch'))) {
            $this->branch = '*';
        }

        return $this->branch;
    }
}
