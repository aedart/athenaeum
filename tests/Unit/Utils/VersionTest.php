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
}
