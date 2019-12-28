<?php


namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\ApplicationIntegrationTestCase;

/**
 * A0_InstanceTest
 *
 * @group application
 * @group application-a0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class A0_InstanceTest extends ApplicationIntegrationTestCase
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
