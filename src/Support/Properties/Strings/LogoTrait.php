<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Logo Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\LogoAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait LogoTrait
{
    /**
     * Path, Uri or other type of location to a logo
     *
     * @var string|null
     */
    protected ?string $logo = null;

    /**
     * Set logo
     *
     * @param string|null $location Path, Uri or other type of location to a logo
     *
     * @return self
     */
    public function setLogo(?string $location)
    {
        $this->logo = $location;

        return $this;
    }

    /**
     * Get logo
     *
     * If no "logo" value set, method
     * sets and returns a default "logo".
     *
     * @see getDefaultLogo()
     *
     * @return string|null logo or null if no logo has been set
     */
    public function getLogo() : ?string
    {
        if ( ! $this->hasLogo()) {
            $this->setLogo($this->getDefaultLogo());
        }
        return $this->logo;
    }

    /**
     * Check if "logo" has been set
     *
     * @return bool True if "logo" has been set, false if not
     */
    public function hasLogo() : bool
    {
        return isset($this->logo);
    }

    /**
     * Get a default "logo" value, if any is available
     *
     * @return string|null Default "logo" value or null if no default value is available
     */
    public function getDefaultLogo() : ?string
    {
        return null;
    }
}
