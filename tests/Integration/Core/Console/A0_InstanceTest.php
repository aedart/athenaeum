<?php

namespace Aedart\Tests\Integration\Core\Console;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Console\AthenaeumCoreConsoleTestCase;

/**
 * A0_InstanceTest
 *
 * @group application
 * @group application-console
 * @group application-console-a0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Console
 */
class A0_InstanceTest extends AthenaeumCoreConsoleTestCase
{
    /**
     * @test
     */
    public function canObtainInstance()
    {
        $console = $this->getArtisan();

        ConsoleDebugger::output($console);

        $this->assertNotNull($console);
    }
}
