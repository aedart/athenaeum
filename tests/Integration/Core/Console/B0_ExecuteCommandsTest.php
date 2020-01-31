<?php

namespace Aedart\Tests\Integration\Core\Console;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Console\AthenaeumCoreConsoleTestCase;

/**
 * B0_ExecuteCommandsTest
 *
 * @group application
 * @group application-console
 * @group application-console-b0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Console
 */
class B0_ExecuteCommandsTest extends AthenaeumCoreConsoleTestCase
{
    /**
     * @test
     */
    public function hasRegisteredCommandsFromConfig()
    {
        $console = $this->getArtisan();

        $commands = $console->all();
        $names = array_keys($commands);

        ConsoleDebugger::output($names);

        $this->assertTrue(in_array('pirate:talk', $names));
    }

    /**
     * @test
     */
    public function canExecuteCommand()
    {
        $exitCode = $this
            ->withoutMockingConsoleOutput()
            ->artisan('pirate:talk');

        $output = $this->getArtisan()->output();
        ConsoleDebugger::output($output);

        $this->assertSame(0, $exitCode, 'Incorrect exist code');
        $this->assertNotEmpty($output);
    }
}
