<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Illuminate\Contracts\Foundation\MaintenanceMode;

/**
 * H0_MaintenanceModeTest
 *
 * @group application
 * @group application-h0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class H0_MaintenanceModeTest extends AthenaeumCoreTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function hasMaintenanceModeDriverRegistered()
    {
        $driver = $this->app->maintenanceMode();

        ConsoleDebugger::output($driver::class);

        $this->assertInstanceOf(MaintenanceMode::class, $driver);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canSetInMaintenanceMode()
    {
        $app = $this->app;

        $app->maintenanceMode()->activate([]);
        $this->assertTrue($app->isDownForMaintenance());

        $app->maintenanceMode()->deactivate();
    }
}
