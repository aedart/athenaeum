<?php

namespace Aedart\Contracts\Utils;

/**
 * Has Driver Profile
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils
 */
interface HasDriverProfile
{
    /**
     * Get this driver's profile name
     *
     * @return string|null
     */
    public function profile(): string|null;
}
