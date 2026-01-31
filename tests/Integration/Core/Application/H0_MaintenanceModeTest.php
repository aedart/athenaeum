<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Attribute\Group;
use Illuminate\Contracts\Foundation\MaintenanceMode;
use PHPUnit\Framework\Attributes\Test;

/**
 * H0_MaintenanceModeTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
#[Group(
    'application',
    'application-h0',
)]
class H0_MaintenanceModeTest extends AthenaeumCoreTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function hasMaintenanceModeDriverRegistered()
    {
        $driver = $this->app->maintenanceMode();

        ConsoleDebugger::output($driver::class);

        $this->assertInstanceOf(MaintenanceMode::class, $driver);
    }

    /**
     * @return void
     */
    #[Test]
    public function canSetInMaintenanceMode()
    {
        $app = $this->app;

        $app->maintenanceMode()->activate([]);
        $this->assertTrue($app->isDownForMaintenance());

        $app->maintenanceMode()->deactivate();
    }
}
