<?php

namespace Naoray\LaravelPackageMaker\Tests\Feature;

use Naoray\LaravelPackageMaker\Tests\TestCase;
use Naoray\LaravelPackageMaker\Traits\InteractsWithTerminal;

class ReplaceTest extends TestCase
{
    use InteractsWithTerminal;

    /** @test */
    public function it_can_replace_a_files_old_string_with_new_ones()
    {
        $fileName = 'ReplaceTest.md';
        $path = './tests/Support/';
        $old = 'TestPackageNamespace';
        $new = 'NewPackageNamespace';

        $this->runConsoleCommand('/bin/echo -n \'# '.$old.'\' >> '.$fileName, $path);

        $this->runReplaceCommand($path, $old, $new);

        $this->assertEquals($this->files->get($path.$fileName), '# '.$new);

        $this->files->delete($path.$fileName);
    }

    /** @test */
    public function it_can_replace_all_files_old_string_with_new_ones_in_a_folder()
    {
        $path = './tests/Support/package/';
        $old = 'test/package';
        $new = 'test/other-package';

        $this->runReplaceCommand($path, $old, $new);

        $this->assertEquals(
            json_decode($this->files->get($path.'composer.json'), true)['name'],
            strtolower($new)
        );

        // revert replacement
        $this->runReplaceCommand($path, $new, $old);
    }

    /**
     * Run replace command.
     *
     * @param string $path
     * @param array  $oldInput
     * @param array  $newInput
     */
    public function runReplaceCommand($path, $oldInput, $newInput)
    {
        $oldInput = is_array($oldInput) ? $oldInput : [$oldInput];
        $newInput = is_array($newInput) ? $newInput : [$newInput];

        $this->artisan('package:replace', [
            'path' => $path,
            '--old' => $oldInput,
            '--new' => $newInput,
        ]);
    }
}
