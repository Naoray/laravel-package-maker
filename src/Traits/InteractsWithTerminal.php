<?php

namespace Naoray\LaravelPackageMaker\Traits;

use Symfony\Component\Process\Process;

trait InteractsWithTerminal
{
    /**
     * Run the given command as a process.
     *
     * @param string $command
     * @param string $path
     */
    protected function runConsoleCommand($command, $path)
    {
        $process = Process::fromShellCommandline($command, $path)->setTimeout(null);
        $process->setTty($process->isTtySupported());

        $process->run(function ($type, $line) {
            $this->command->output->write($line);
        });
    }
}
