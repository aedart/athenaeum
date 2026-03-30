<?php

namespace Aedart\Tests\Integration\Core\Console;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Console\AthenaeumCoreConsoleTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * A0_InstanceTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Console
 */
#[Group(
    'application',
    'application-console',
    'application-console-a0',
)]
class A0_InstanceTest extends AthenaeumCoreConsoleTestCase
{
    #[Test]
    public function canObtainInstance()
    {
        $console = $this->getArtisan();

        ConsoleDebugger::output($console);

        $this->assertNotNull($console);
    }
}
