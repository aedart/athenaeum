<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * A0_InstanceTest
 *
 * @group application
 * @group application-a0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
#[Group(
    'application',
    'application-a0',
)]
class A0_InstanceTest extends AthenaeumCoreTestCase
{
    /**
     * @test
     */
    #[Test]
    public function canObtainInstance()
    {
        ConsoleDebugger::output($this->app);

        $this->assertNotNull($this->app);
    }
}
