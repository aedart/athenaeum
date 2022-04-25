<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Version;
use Codeception\Configuration;

/**
 * BuildVersionTest
 *
 * @group utils
 * @group version
 * @group build-version
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils
 */
class BuildVersionTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canBuildVersionFile()
    {
        $buildCommand = realpath(__DIR__ . '/../../../packages/Utils/bin/build-version');

        //dd($buildCommand);

        // NOTE: file path is relative to the execution scripts' current working directory
        $outputFile = 'tests/_output/version';

        // Build version
        $result = shell_exec("{$buildCommand} $outputFile");
        $this->assertFileExists($outputFile);

        // Attempt to parse version
        $version = Version::application($outputFile);

        ConsoleDebugger::output($version);

        [$versionInFile, $reference] = explode('@', file_get_contents($outputFile));

        $this->assertNotEmpty($version);
        $this->assertSame($versionInFile, $version->version());
        $this->assertSame($reference, $version->reference());
    }
}