<?php

namespace Aedart\Tests\Unit\Utils\Concerns;

use Aedart\Contracts\Utils\HasDriver;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Concerns\Driver;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * DriverTest
 *
 * @group utils
 * @group driver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Concerns
 */
#[Group(
    'utils',
    'driver',
)]
class DriverTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Makes a new "driver"
     *
     * @return HasDriver
     */
    public function makeDriver(): HasDriver
    {
        $driver = new class() implements HasDriver {
            use Driver;

            protected function makeDriver(): mixed
            {
                return 'my_actual_driver_instance';
            }
        };

        return new $driver();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainDriver(): void
    {
        $driver = $this->makeDriver();

        $result = $driver->driver();

        $this->assertNotNull($result);
    }
}
