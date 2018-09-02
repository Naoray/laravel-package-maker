<?php

namespace Naoray\LaravelPackageMaker\Tests\Feature;

use Naoray\LaravelPackageMaker\Tests\TestCase;

class SavePackageCredentialsTest extends TestCase
{
    /** @test */
    public function it_can_save_the_given_credentials_to_the_cache()
    {
        $namespace = 'Test\Package';
        $path = './tests/Support/package';

        $this->artisan('package:save', [
            'namespace' => $namespace,
            'path' => $path,
        ]);

        $this->assertEquals($namespace, cache()->get('package:namespace'));
        $this->assertEquals($path, cache()->get('package:path'));
    }
}
