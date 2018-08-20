<?php

namespace Naoray\LaravelPackageMaker\Commands\Foundation;

use Naoray\LaravelPackageMaker\Traits\HasNameAttribute;
use Naoray\LaravelPackageMaker\Traits\CreatesPackageStubs;
use Illuminate\Foundation\Console\NotificationMakeCommand as MakeNotification;

class NotificationMakeCommand extends MakeNotification
{
    use CreatesPackageStubs, HasNameAttribute;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:package:notification';

    /**
     * Get the destination class path.
     *
     * @return string
     */
    protected function resolveDirectory()
    {
        return $this->getDirInput().'/src';
    }

    /**
     * Write the Markdown template for the mailable.
     *
     * @return void
     */
    protected function writeMarkdownTemplate()
    {
        $path = base_path($this->getDirInput().'/resources/views/'.str_replace('.', '/', $this->option('markdown'))).'.blade.php';

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $this->files->put($path, $this->getStubViewPath());
    }

    /**
     * Get Markdown stub view from parent dir.
     *
     * @return string
     */
    protected function getStubViewPath()
    {
        $parentFileName = (new \ReflectionClass('Illuminate\Foundation\Console\NotificationMakeCommand'))->getFileName();

        return file_get_contents(
            dirname($parentFileName).'/stubs/markdown.stub'
        );
    }
}
