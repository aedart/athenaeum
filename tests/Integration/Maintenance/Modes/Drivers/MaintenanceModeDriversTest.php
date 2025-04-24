<?php

namespace Aedart\Tests\Integration\Maintenance\Modes\Drivers;

use Aedart\Maintenance\Modes\Drivers\ArrayBasedMode;
use Aedart\Maintenance\Modes\Drivers\JsonFileBasedMode;
use Aedart\Tests\TestCases\Maintenance\Modes\MaintenanceModesTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Illuminate\Contracts\Foundation\MaintenanceMode;
use PHPUnit\Framework\Attributes\Test;

/**
 * MaintenanceModeDriversTest
 *
 * @group maintenance-modes
 * @group maintenance-modes-drivers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Maintenance\Modes\Drivers
 */
#[Group(
    'maintenance-modes',
    'maintenance-modes-drivers',
)]
class MaintenanceModeDriversTest extends MaintenanceModesTestCase
{
    /*****************************************************************
     * Providers
     ****************************************************************/

    /**
     * Provides maintenance mode drivers
     *
     * @return array[]
     */
    public function providesDrivers(): array
    {
        return [
            'array' => [ new ArrayBasedMode() ],
            'json' => [ new JsonFileBasedMode($this->outputDir() . '/down.json') ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesDrivers
     *
     * @param  MaintenanceMode  $driver
     *
     * @return void
     */
    #[DataProvider('providesDrivers')]
    #[Test]
    public function canActiveAndDeactivate(MaintenanceMode $driver)
    {
        $driver->activate([]);
        $this->assertTrue($driver->active());

        $driver->deactivate();
        $this->assertFalse($driver->active());
    }

    /**
     * @test
     * @dataProvider providesDrivers
     *
     * @param  MaintenanceMode  $driver
     *
     * @return void
     */
    #[DataProvider('providesDrivers')]
    #[Test]
    public function canActiveWithPayload(MaintenanceMode $driver)
    {
        $payload = [
            'random' => $this->getFaker()->randomDigitNotNull()
        ];

        $driver->activate($payload);
        $this->assertTrue($driver->active());

        $result = $driver->data();
        $this->assertArrayHasKey('random', $result, 'Payload was not stored');
        $this->assertSame($payload['random'], $result['random'], 'Invalid payload retrieved');
    }
}
