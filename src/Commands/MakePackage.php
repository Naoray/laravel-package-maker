<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakePackage extends Command
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
                             {mail? : Author\'s email address}
                             {copyright? : Copyright will be placed in the LICENSE file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new package and adds it to this lab.';

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
    protected $mail;

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

        if (! $this->confirm('Do you wish to continue?')) {
            return $this->error('Canceled command!');
        }

        $packagePath = $this->getPackagePath();

        if ($this->alreadyExists($packagePath)) {
            return $this->error('The package already exists!');
        }

        $this->createDirectories($packagePath);
        $this->createCommonFiles($packagePath);

        $this->createComposer($packagePath);
        $this->createServiceProvider($packagePath);
        $this->createTestCase($packagePath);

        $this->createContinousIntegrationService($packagePath);
        $this->createCodeQualityService($packagePath);
        $this->createCodeCoverageService($packagePath);

        $this->callSilent('package:add', [
            'name'                  => $this->packageName,
            'path'                  => $this->dir.$this->packageName,
            'vendor'                => $this->vendor,
            'branch'                => 'master',
            '--without-interaction' => true,
        ]);
    }

    /**
     * Checks for needed input and prints it out.
     * 
     * @return void
     */
    public function checkForInputs()
    {
        $name = $this->getNameInput();
        $vendor = $this->getVendorInput();
        $dir = $this->getDirectoryInput();
        $author = $this->getAuthorInput();
        $mail = $this->getMailInput();
        $copyright = $this->getCopyrightInput();

        $this->table(
            ['Name', 'Vendor', 'Directory', 'Author', 'E-mail', 'Copyright'],
            [
                [$name, $vendor, $dir, $author, $mail, $copyright],
            ]
        );
    }

    /**
     * @param string $path
     * 
     * @return void
     */
    protected function createDirectories($path)
    {
        // create base path if it does not exist
        if (! $this->alreadyExists($this->getBasePath())) {
            $this->files->makeDirectory($this->getBasePath());
        }

        $this->files->makeDirectory($path);
        $this->info('Package directory created successfully!');

        $this->files->makeDirectory($path.'/src');
        $this->info('Source directory created successfully!');

        $this->files->makeDirectory($path.'/tests');
        $this->info('Tests directory created successfully!');
    }

    /**
     * Create common files.
     *
     * @param string $path
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * 
     * @return void
     */
    protected function createCommonFiles($path)
    {
        $this->files->put($path.'/readme.md', $this->buildFile('readme'));
        $this->files->put($path.'/LICENSE.md', $this->buildFile('LICENSE'));
        $this->files->put($path.'/CONTRIBUTING.md', $this->buildFile('CONTRIBUTING'));
        $this->files->put($path.'/phpunit.xml', $this->buildFile('phpunit'));
        $this->files->put($path.'/.gitignore', $this->buildFile('.gitignore'));

        $this->info('Common files created successfully!');
    }

    /**
     * @param string $path
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * 
     * @return void
     */
    protected function createComposer($path)
    {
        $this->files->put($path.'/composer.json', $this->buildFile('composer'));

        $this->info('Composer created successfully!');
    }

    /**
     * @param string $path
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * 
     * @return void
     */
    protected function createServiceProvider($path)
    {
        $this->files->put(
            $path.'/src/'.$this->getPackageName().'ServiceProvider.php',
            $this->buildFile('src/provider')
        );

        $this->info('Service Provider created successfully!');
    }

    /**
     * @param string $path
     * 
     * @return void
     */
    protected function createTestCase($path)
    {
        $this->files->put(
            $path.'/tests/TestCase.php',
            $this->buildFile('tests/TestCase')
        );

        $this->info('Test Case created sucessfully!');
    }

    /**
     * @param string $path
     * 
     * @return void
     */
    protected function createContinousIntegrationService($path)
    {
        $CI = $this->choice('What CI/CD service you want to use?', ['TravisCI'], 'TravisCI');

        switch($CI) {
            case 'TravisCI':
                $this->files->put($path.'/.travis.yml', $this->buildFile('.travis'));
                break;
            default:
                break;
        }

        $this->info('CI/CD provider was set up!');
    }

    /**
     * @param string $path
     * 
     * @return void
     */
    protected function createCodeQualityService($path)
    {
        $CQ = $this->choice('What code quality service you want to use?', ['StyleCI'], 'StyleCI');

        switch($CQ) {
            case 'StyleCI':
                $this->files->put($path.'/.styleci.yml', $this->buildFile('.styleci'));
                break;
            default:
                break;
        }

        $this->info('Code quality provider was set up!');
    }

    /**
     * @param string $path
     * 
     * @return void
     */
    protected function createCodeCoverageService($path)
    {
        $CC = $this->choice('What code coverage service you want to use?', ['Codecov'], 'Codecov');

        switch($CC) {
            case 'Codecov':
                $this->files->put($path.'/codecov.yml', $this->buildFile('codecov'));
                break;
            default:
                break;
        }

        $this->info('Code coverage provider was set up!');
    }

    /**
     * @param string $name
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return \Naoray\LaravelPackageMaker\Commands\MakePackage
     */
    protected function buildFile($name)
    {
        $stub = $this->files->get(__DIR__.'/../../resources/stubs/'.$name.'.stub');

        return $this->replaceNamespaces($stub)
            ->replaceNames($stub)
            ->replaceCredentials($stub);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param string $stub
     *
     * @return \Naoray\LaravelPackageMaker\Commands\MakePackage
     */
    protected function replaceNamespaces(&$stub)
    {
        $stub = str_replace(
            ['DummyComposerNamespace', 'DummyComposerProviderNamespace', 'DummyRootNamespace'],
            [$this->getComposerNamespace(), $this->getComposerProviderNamespace(), $this->getRootNamespace()],
            $stub
        );

        return $this;
    }

    /**
     * Replace the names for the given stub.
     *
     * @param string $stub
     *
     * @return \Naoray\LaravelPackageMaker\Commands\MakePackage
     */
    protected function replaceNames(&$stub)
    {
        $stub = str_replace(
            ['DummyVendorName', 'DummyPackageName', 'DummyClass', 'CompanyOrVendorName'],
            [$this->vendor, $this->packageName, $this->getPackageName().'ServiceProvider', $this->copyright],
            $stub
        );

        return $this;
    }

    /**
     * Replace Author credentials.
     *
     * @param $stub
     *
     * @return string
     */
    protected function replaceCredentials(&$stub)
    {
        $stub = str_replace(
            ['DummyAuthorName', 'DummyAuthorEmail'],
            [$this->author, $this->mail],
            $stub
        );

        return $stub;
    }

    /**
     * @return string
     */
    protected function getRootNamespace()
    {
        return ucfirst($this->vendor).'\\'.$this->getPackageName();
    }

    /**
     * @return string
     */
    protected function getPackageName()
    {
        return ucfirst(camel_case($this->packageName));
    }

    /**
     * @return string
     */
    protected function getComposerNamespace()
    {
        return ucfirst($this->vendor).'\\\\'.$this->getNamespace();
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        return ucfirst(camel_case($this->packageName)).'\\\\';
    }

    /**
     * @return string
     */
    protected function getComposerProviderNamespace()
    {
        return $this->getComposerNamespace().$this->getPackageName().'ServiceProvider';
    }

    /**
     * Determine if the class already exists.
     *
     * @param string $path
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
    protected function getBasePath()
    {
        $path = ends_with($this->dir, '/') ? $this->dir : $this->dir.'/';

        return base_path().'/'.$path;
    }

    /**
     * @return string
     */
    protected function getPackagePath()
    {
        return $this->getBasePath().$this->packageName;
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
    public function getMailInput()
    {
        if ($this->mail) {
            return $this->mail;
        }

        if (! $this->mail = $this->argument('mail')) {
            $this->mail = $this->ask('What\'s the mantainer\'s e-mail?');
        }

        return $this->mail;
    }
}
