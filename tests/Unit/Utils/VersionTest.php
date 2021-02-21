<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Version;
use OutOfBoundsException;

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
        $version = Version::package('aedart/athenaeum');

        ConsoleDebugger::output((string) $version);

        $this->assertNotEmpty($version);
    }

    /**
     * @test
     */
    public function failsDeterminingVersionOfUnknownPackage()
    {
        $this->expectException(OutOfBoundsException::class);

        Version::package('acme/unknown-pgk-' . $this->getFaker()->word);
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

        $resultB = Version::hasFor('acme/unknown-pgk-' . $this->getFaker()->word);
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
}
