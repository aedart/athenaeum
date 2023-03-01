<?php

namespace Aedart\Utils\Concerns;

/**
 * Concerns "Profile Based" Driver
 *
 * @see \Aedart\Contracts\Utils\HasMockableDriver
 * @see \Aedart\Contracts\Utils\HasDriverProfile
 * @see \Aedart\Contracts\Utils\HasDriverOptions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Concerns
 */
trait ProfileBasedDriver
{
    use MockableDriver;
    use DriverProfile;
    use DriverOptions;
}
