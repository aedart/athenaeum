<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Contracts\Utils\Packages\Exceptions\PackageNotInstalledException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Version;

/**
 * VersionTest
 *
 * @group utils
 * @group version
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
class VersionTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canDetermineVersionOfPackage()
    {
        $version = Version::package('illuminate/support');

        ConsoleDebugger::output((string) $version);

        $this->assertNotEmpty($version);
    }

    /**
     * @test
     */
    public function failsDeterminingVersionOfUnknownPackage()
    {
        $this->expectException(PackageNotInstalledException::class);

        Version::package('acme/unknown-pgk-' . $this->getFaker()->word());
    }

    /**
     * @test
     */
    public function cachesPackageVersion()
    {
        $package = 'aedart/athenaeum';

        Version::package($package);

        $cache = Version::cached();

        ConsoleDebugger::output($cache);

        $this->assertArrayHasKey($package, $cache);
    }

    /**
     * @test
     */
    public function canClearCachedPackageVersion()
    {
        $package = 'aedart/athenaeum';

        Version::package($package);
        Version::clearCached();

        $cache = Version::cached();

        $this->assertEmpty($cache);
    }

    /**
     * @test
     */
    public function canDetermineIfVersionIsAvailableForPackage()
    {
        $resultA = Version::hasFor('aedart/athenaeum');
        $this->assertTrue($resultA, 'Should exist for A');

        $resultB = Version::hasFor('acme/unknown-pgk-' . $this->getFaker()->word());
        $this->assertFalse($resultB, 'Should not exist for B');
    }

    /**
     * @test
     */
    public function canGetApplicationVersion()
    {
        $version = Version::application();

        ConsoleDebugger::output((string)$version);

        $this->assertNotEmpty($version);
    }

    /**
     * @test
     */
    public function canObtainAthenaeumPackageVersion()
    {
        $version = Version::package('aedart/athenaeum-support');

        ConsoleDebugger::output((string)$version);

        $this->assertNotEmpty($version);
        $this->assertStringNotContainsString('no version', $version);
    }
}
