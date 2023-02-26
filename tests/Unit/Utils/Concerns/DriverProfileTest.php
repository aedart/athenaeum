<?php

namespace Aedart\Tests\Unit\Utils\Concerns;

use Aedart\Contracts\Utils\HasDriverProfile;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Concerns\DriverProfile;

/**
 * DriverProfileTest
 *
 * @group utils
 * @group driver-profile
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Concerns
 */
class DriverProfileTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Makes a new "driver" with profile name
     *
     * @param  string|null  $profile
     *
     * @return HasDriverProfile
     */
    public function makeDriver(string|null $profile): HasDriverProfile
    {
        $driver = new class($profile) implements HasDriverProfile {
            use DriverProfile;

            public function __construct(string|null $profile)
            {
                $this->setProfile($profile);
            }
        };

        return new $driver($profile);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
    public function canObtainProfile(): void
    {
        $profile = 'my_driver_profile_name';
        $driver = $this->makeDriver($profile);

        $result = $driver->profile();

        $this->assertSame($profile, $result);
    }
}
