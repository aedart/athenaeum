<?php

namespace Aedart\Tests\Integration\Core\Console;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Console\AthenaeumCoreConsoleTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * B0_ExecuteCommandsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Console
 */
#[Group(
    'application',
    'application-console',
    'application-console-b0',
)]
class B0_ExecuteCommandsTest extends AthenaeumCoreConsoleTestCase
{
    #[Test]
    public function hasRegisteredCommandsFromConfig()
    {
        $console = $this->getArtisan();

        $commands = $console->all();
        $names = array_keys($commands);

        ConsoleDebugger::output($names);

        $this->assertTrue(in_array('pirate:talk', $names));
    }

    #[Test]
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
