<?php

namespace Naoray\LaravelPackageMaker\Tests\Feature;

use Naoray\LaravelPackageMaker\Tests\TestCase;

class DeletePackageCredentialsTest extends TestCase
{
    /** @test */
    public function it_can_delete_package_credentials_from_cache()
    {
        $this->artisan('package:save', [
            'namespace' => 'Test\Package',
            'path' => './tests/Support/package',
        ]);

        $this->artisan('package:delete');

        $this->assertNull(cache()->get('package:namespace'));
        $this->assertNull(cache()->get('package:path'));
    }
}
