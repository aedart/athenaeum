<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Anniversary Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\AnniversaryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait AnniversaryTrait
{
    /**
     * Date of anniversary
     *
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $anniversary = null;

    /**
     * Set anniversary
     *
     * @param \DateTimeInterface|null $anniversary Date of anniversary
     *
     * @return self
     */
    public function setAnniversary(\DateTimeInterface|null $anniversary): static
    {
        $this->anniversary = $anniversary;

        return $this;
    }

    /**
     * Get anniversary
     *
     * If no anniversary value set, method
     * sets and returns a default anniversary.
     *
     * @see getDefaultAnniversary()
     *
     * @return \DateTimeInterface|null anniversary or null if no anniversary has been set
     */
    public function getAnniversary(): \DateTimeInterface|null
    {
        if (!$this->hasAnniversary()) {
            $this->setAnniversary($this->getDefaultAnniversary());
        }
        return $this->anniversary;
    }

    /**
     * Check if anniversary has been set
     *
     * @return bool True if anniversary has been set, false if not
     */
    public function hasAnniversary(): bool
    {
        return isset($this->anniversary);
    }

    /**
     * Get a default anniversary value, if any is available
     *
     * @return \DateTimeInterface|null Default anniversary value or null if no default value is available
     */
    public function getDefaultAnniversary(): \DateTimeInterface|null
    {
        return null;
    }
}
