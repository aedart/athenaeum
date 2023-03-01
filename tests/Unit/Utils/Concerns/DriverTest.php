<?php

namespace Aedart\Tests\Unit\Utils\Concerns;

use Aedart\Contracts\Utils\HasDriver;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Concerns\Driver;

/**
 * DriverTest
 *
 * @group utils
 * @group driver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Concerns
 */
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
    public function canObtainDriver(): void
    {
        $driver = $this->makeDriver();

        $result = $driver->driver();

        $this->assertNotNull($result);
    }
}
