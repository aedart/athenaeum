<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;

/**
 * A0_InstanceTest
 *
 * @group application
 * @group application-a0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class A0_InstanceTest extends AthenaeumCoreTestCase
{
    /**
     * @test
     */
    public function canObtainInstance()
    {
        ConsoleDebugger::output($this->app);

        $this->assertNotNull($this->app);
    }
}
