<?php

namespace Naoray\LaravelPackageMaker\Commands;

use Illuminate\Console\Command;

class NovaMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:nova';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new nova package.';

    /**
     * Source from which the tool will be cloned.
     *
     * @var string
     */
    protected $skeletonSrc = 'https://github.com/spatie/skeleton-nova-tool';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $author = $this->ask('Name of the author? (e.g. Freek Van der Herten)');
        $authorUsername = $this->ask('Author\'s username! (e.g. freekmurze)');
        $authorEmail = $this->ask('Your email! (e.g. freek@spatie.be)');
        $name = $this->ask('Name your package! (e.g. nova-tail-tool)');
        $description = $this->ask('Package Description! (e.g. A tool to tail the log)');
        $vendor = $this->ask('Vendor Name! (e.g. spatie)');
        $vendorNamespace = $this->ask('Namespace Vendor Name! (e.g. Spatie)');
        $toolNamespace = $this->ask('Namespace Tool Name! (e.g. TailTool)');

        $target = $this->anticipate('Where to install your package?', ['../packages/'.$name, 'packages/'.$name]);

        $this->clone($target);
        $this->replaceOld(
            $target,
            $author,
            $authorUsername,
            $authorEmail,
            $name,
            $description,
            $vendor,
            $vendorNamespace,
            $toolNamespace
        );

        if ($this->confirm('Would you like to load your package via composer?')) {
            $this->callSilent('package:add', [
                'name' => $name,
                'path' => $target,
                'vendor' => $vendor,
                'branch' => 'master',
                '--without-interaction' => true,
            ]);
        }
    }

    /**
     * Clone skeleton-nova-tool.
     *
     * @param string $target
     * @return void
     */
    public function clone($target)
    {
        $this->call('package:clone', [
            'src' => $this->skeletonSrc,
            'target' => $target,
        ]);
    }

    /**
     * Replace old inputs with new ones.
     *
     * @param string $target
     * @param array ...$new
     * @return void
     */
    public function replaceOld($target, ...$new)
    {
        $this->callSilent('package:replace', [
            'path' => $target,
            '--old' => [
                ':author_name',
                ':author_username',
                ':author_email',
                ':package_name',
                ':package_description',
                ':vendor',
                ':namespace_vendor',
                ':namespace_tool_name',
            ],
            '--new' => $new,
        ]);
    }
}
