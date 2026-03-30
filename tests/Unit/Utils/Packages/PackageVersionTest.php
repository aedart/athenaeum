<?php

namespace Aedart\Tests\Unit\Utils\Packages;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Packages\PackageVersion;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * PackageVersionTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Packages
 */
#[Group(
    'utils',
    'version',
    'package-version',
)]
class PackageVersionTest extends UnitTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function canCreatePackageVersion()
    {
        $name = 'acme/silly-package';
        $version = '1.0.1';
        $fullVersion = '1.0.1.0';
        $reference = sha1($name . $fullVersion);

        $packageVersion = new PackageVersion(
            name: $name,
            version: $version,
            fullVersion: $fullVersion,
            reference: $reference
        );

        $this->assertSame($name, $packageVersion->name(), 'incorrect package name');
        $this->assertSame($version, $packageVersion->version(), 'incorrect version');

        $this->assertTrue($packageVersion->hasFullVersion(), 'should have full version');
        $this->assertSame($fullVersion, $packageVersion->fullVersion(), 'incorrect full version');

        $this->assertTrue($packageVersion->hasReference(), 'should have reference');
        $this->assertSame($reference, $packageVersion->reference(), 'incorrect reference');
    }

    /**
     * @return void
     */
    #[Test]
    public function canCastToString()
    {
        $name = 'acme/other-package';
        $version = '1.0.1';

        $packageVersion = new PackageVersion(
            name: $name,
            version: $version
        );

        $this->assertSame($version, (string) $packageVersion);

        $this->assertFalse($packageVersion->hasFullVersion(), 'should not have full version');
        $this->assertFalse($packageVersion->hasReference(), 'should not have reference');
    }
}
