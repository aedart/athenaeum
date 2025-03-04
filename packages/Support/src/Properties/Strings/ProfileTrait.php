<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Profile Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ProfileAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ProfileTrait
{
    /**
     * The profile of someone or something
     *
     * @var string|null
     */
    protected string|null $profile = null;

    /**
     * Set profile
     *
     * @param string|null $profile The profile of someone or something
     *
     * @return self
     */
    public function setProfile(string|null $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * If no profile value set, method
     * sets and returns a default profile.
     *
     * @see getDefaultProfile()
     *
     * @return string|null profile or null if no profile has been set
     */
    public function getProfile(): string|null
    {
        if (!$this->hasProfile()) {
            $this->setProfile($this->getDefaultProfile());
        }
        return $this->profile;
    }

    /**
     * Check if profile has been set
     *
     * @return bool True if profile has been set, false if not
     */
    public function hasProfile(): bool
    {
        return isset($this->profile);
    }

    /**
     * Get a default profile value, if any is available
     *
     * @return string|null Default profile value or null if no default value is available
     */
    public function getDefaultProfile(): string|null
    {
        return null;
    }
}
