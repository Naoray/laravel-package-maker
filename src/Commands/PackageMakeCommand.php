<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class PackageMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package
                             {name? : The name of the package}
                             {vendor? : Vendor name of the package}
                             {dir? : Directory where the package will be stored}
                             {author? : Author of the package}
                             {email? : Author\'s email address}
                             {copyright? : Copyright will be placed in the LICENSE file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new package';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Name of the package.
     *
     * @var string
     */
    protected $packageName;

    /**
     * Directory where the package will be stored.
     *
     * @var string
     */
    protected $dir;

    /**
     * Copyright fields which will be placed inside the License.md file.
     *
     * @var string
     */
    protected $copyright;

    /**
     * The packages vendor name.
     *
     * @var string
     */
    protected $vendor;

    /**
     * The packages author.
     *
     * @var string
     */
    protected $author;

    /**
     * The mantainer's email address.
     *
     * @var string
     */
    protected $email;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkForInputs();

        if (! $this->option('no-interaction') && ! $this->confirm('Do you wish to continue?')) {
            return $this->error('Canceled command!');
        }

        if ($this->alreadyExists($this->packagePath())) {
            return $this->error('The package already exists!');
        }

        $this->createCommonFiles();
        $this->createComposer();
        $this->createServiceProvider();
        $this->createBaseTestCase();

        $this->configureCICDService();
        $this->configureCodeQualityService();
        $this->configureCodeCoverageService();

        $this->info('Package successfully created!');

        $this->call('package:save', [
            'namespace' => $this->rootNamespace(),
            'path' => $this->dir.$this->packageName,
        ]);

        $this->callSilent('package:add', [
            'name' => $this->packageName,
            'path' => $this->dir.$this->packageName,
            'vendor' => $this->vendor,
            'branch' => 'master',
            '--no-interaction' => true,
        ]);
    }

    /**
     * Create common files.
     *
     * @param $path
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function createCommonFiles()
    {
        $this->call('package:readme', array_merge(
            $this->packageOptions(),
            [
                '--author' => $this->author,
                '--email' => $this->email,
            ]
        ));
        $this->call('package:license', array_merge(
            $this->packageOptions(),
            ['--copyright' => $this->copyright]
        ));
        $this->call('package:contribution', $this->packageOptions());
        $this->call('package:phpunit', $this->packageOptions());
        $this->call('package:gitignore', $this->packageOptions());
    }

    /**
     * Configure service for CI/CD.
     *
     * @param $path
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function configureCICDService()
    {
        $cicdServices = [
            'None' => function () {
            },
            'TravisCI' => function () {
                $this->call('package:travis', $this->packageOptions());
            },
        ];

        $cicd = $this->choice(
            'What CI/CD service you want to configure?',
            array_keys($cicdServices),
            0
        );

        $cicdServices[$cicd]();
    }

    /**
     * Configure service for Code Quality.
     *
     * @param $path
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function configureCodeQualityService()
    {
        $codeQualityServices = [
            'None' => function () {
            },
            'StyleCI' => function () {
                $this->call('package:styleci', $this->packageOptions());
            },
        ];

        $codeQuality = $this->choice(
            'What Code Quality service you want to configure?',
            array_keys($codeQualityServices),
            0
        );

        $codeQualityServices[$codeQuality]();
    }

    /**
     * Configure service for Code Coverage.
     *
     * @param $path
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function configureCodeCoverageService()
    {
        $codeCoverageServices = [
            'None' => function () {
            },
            'Codecov' => function () {
                $this->call('package:codecov', $this->packageOptions());
            },
        ];

        $codeCoverage = $this->choice(
            'What Code Coverage service you want to configure?',
            array_keys($codeCoverageServices),
            0
        );

        $codeCoverageServices[$codeCoverage]();
    }

    /**
     * Creates composer file.
     */
    protected function createComposer()
    {
        $this->call('package:composer', array_merge(
            $this->packageOptions(),
            [
                '--author' => $this->author,
                '--email' => $this->email,
            ]
        ));
    }

    /**
     * Creates package service provider.
     */
    protected function createServiceProvider()
    {
        $this->call('package:provider', array_merge(
            [
                'name' => $this->packageName().'ServiceProvider',
            ],
            $this->packageOptions()
        ));
    }

    /**
     * Creates base test.
     */
    protected function createBaseTestCase()
    {
        $this->call('package:basetest', array_merge(
            [
                'provider' => $this->packageName().'ServiceProvider',
            ],
            $this->packageOptions()
        ));
    }

    /**
     * Get package options.
     *
     * @return array
     */
    protected function packageOptions()
    {
        return [
            '--namespace' => $this->rootNamespace(),
            '--dir' => $this->packagePath(),
        ];
    }

    /**
     * @return string
     */
    protected function rootNamespace()
    {
        return ucfirst($this->vendor).'\\'.$this->packageName();
    }

    /**
     * @return string
     */
    protected function packageName()
    {
        return ucfirst(Str::camel($this->packageName));
    }

    /**
     * Determine if the class already exists.
     *
     * @param $path
     *
     * @return bool
     */
    protected function alreadyExists($path)
    {
        return $this->files->isDirectory($path);
    }

    /**
     * @return string
     */
    protected function packagePath()
    {
        return $this->getDirectoryInput().$this->packageName;
    }

    /**
     * Checks for needed input and prints it out.
     */
    public function checkForInputs()
    {
        $name = $this->getNameInput();
        $vendor = $this->getVendorInput();
        $dir = $this->getDirectoryInput();
        $author = $this->getAuthorInput();
        $email = $this->getEmailInput();
        $copyright = $this->getCopyrightInput();

        $this->table(
            ['Name', 'Vendor', 'Directory', 'Author', 'E-mail', 'Copyright'],
            [
                [$name, $vendor, $dir, $author, $email, $copyright],
            ]
        );
    }

    /**
     * Get the desired directory path from the input.
     *
     * @return string
     */
    protected function getDirectoryInput()
    {
        if ($this->dir) {
            return $this->dir;
        }

        if (! $this->dir = $this->argument('dir')) {
            $this->dir = $this->anticipate('Where should the package be installed?', ['../packages/', 'packages/']);
        }

        return $this->dir;
    }

    /**
     * Get copyright input.
     *
     * @return string
     */
    public function getCopyrightInput()
    {
        if ($this->copyright) {
            return $this->copyright;
        }

        if (! $this->copyright = $this->argument('copyright')) {
            $this->copyright = $this->ask('Who will hold the copyrights?');
        }

        return $this->copyright;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        if ($this->packageName) {
            return $this->packageName;
        }

        if (! $this->packageName = trim($this->argument('name'))) {
            $this->packageName = $this->ask('What\'s your packages name?');
        }

        return $this->packageName;
    }

    /**
     * Get the desired vendor name from the input.
     *
     * @return string
     */
    protected function getVendorInput()
    {
        if ($this->vendor) {
            return $this->vendor;
        }

        if (! $this->vendor = trim($this->argument('vendor'))) {
            $this->vendor = $this->ask('What\'s the packages github name (vendor name of the package)?');
        }

        return $this->vendor;
    }

    /**
     * Get the author name input.
     *
     * @return string
     */
    public function getAuthorInput()
    {
        if ($this->author) {
            return $this->author;
        }

        if (! $this->author = $this->argument('author')) {
            $this->author = $this->ask('Who is the author of the package?');
        }

        return $this->author;
    }

    /**
     * Get mail input.
     *
     * @return string
     */
    public function getEmailInput()
    {
        if ($this->email) {
            return $this->email;
        }

        if (! $this->email = $this->argument('email')) {
            $this->email = $this->ask('What\'s the mantainer\'s e-mail?');
        }

        return $this->email;
    }
}
