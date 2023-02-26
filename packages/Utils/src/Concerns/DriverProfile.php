<?php

namespace Aedart\Utils\Concerns;

/**
 * Concerns Driver Profile
 *
 * @see \Aedart\Contracts\Utils\HasDriverProfile
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Concerns
 */
trait DriverProfile
{
    /**
     * Driver profile name
     *
     * @var string|null
     */
    protected string|null $profile = null;

    /**
     * Get this driver's profile name
     *
     * @return string|null
     */
    public function profile(): string|null
    {
        return $this->profile;
    }

    /**
     * Set this driver's profile name
     *
     * @param  string|null  $profile
     *
     * @return self
     */
    protected function setProfile(string|null $profile): static
    {
        $this->profile = $profile;

        return $this;
    }
}
