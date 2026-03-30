<?php

namespace Aedart\Tests\Integration\Maintenance\Modes;

use Aedart\Maintenance\Modes\FallbackManager;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Maintenance\Modes\MaintenanceModesTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Illuminate\Contracts\Foundation\MaintenanceMode;
use PHPUnit\Framework\Attributes\Test;

/**
 * LaravelIntegrationTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Maintenance\Modes
 */
#[Group(
    'maintenance-modes',
    'maintenance-modes-integration-to-laravel',
)]
class LaravelIntegrationTest extends MaintenanceModesTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides driver names
     *
     * @return string[]
     */
    public function providesDrivers(): array
    {
        return [
            'array' => ['array'],
            'json' => ['json'],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     */
    #[Test]
    public function fallbackManagerNotRegistered()
    {
        $manager = $this->getMaintenanceModeManager();

        // We assume that a regular Laravel application is used, so the fallback
        // manager SHOULD NOT be registered. Only the drivers should be added to
        // whatever manager Laravel uses.
        $this->assertNotInstanceOf(FallbackManager::class, $manager);
    }

    /**
     * @param  string  $name
     * @return void
     */
    #[DataProvider('providesDrivers')]
    #[Test]
    public function hasInstalledDriver(string $name)
    {
        $manager = $this->getMaintenanceModeManager();

        $drive = $manager->driver($name);

        ConsoleDebugger::output($drive::class);

        $this->assertInstanceOf(MaintenanceMode::class, $drive);
    }
}
