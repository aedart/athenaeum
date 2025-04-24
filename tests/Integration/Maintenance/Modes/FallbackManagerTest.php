<?php

namespace Aedart\Tests\Integration\Maintenance\Modes;

use Aedart\Maintenance\Modes\Drivers\ArrayBasedMode;
use Aedart\Tests\TestCases\Maintenance\Modes\MaintenanceModesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Contracts\Foundation\MaintenanceMode;
use PHPUnit\Framework\Attributes\Test;

/**
 * FallbackManagerTest
 *
 * @group maintenance-modes
 * @group maintenance-modes-manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Maintenance\Modes
 */
#[Group(
    'maintenance-modes',
    'maintenance-modes-manager',
)]
class FallbackManagerTest extends MaintenanceModesTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    #[Test]
    public function canObtainInstance()
    {
        $manager = $this->createFallbackManager();

        $this->assertNotNull($manager);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    #[Test]
    public function returnsDefaultDriver()
    {
        $manager = $this->createFallbackManager();

        $driver = $manager->driver();

        $this->assertInstanceOf(MaintenanceMode::class, $driver);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    #[Test]
    public function canObtainSpecificDriver()
    {
        $manager = $this->createFallbackManager();

        $driver = $manager->driver('array');

        $this->assertInstanceOf(ArrayBasedMode::class, $driver);
    }
}
