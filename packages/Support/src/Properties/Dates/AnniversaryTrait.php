<?php

namespace Aedart\Support\Properties\Dates;

/**
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
     * @var \DateTime|null
     */
    protected \DateTime|null $anniversary = null;

    /**
     * Set anniversary
     *
     * @param \DateTime|null $anniversary Date of anniversary
     *
     * @return self
     */
    public function setAnniversary(\DateTime|null $anniversary): static
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
     * @return \DateTime|null anniversary or null if no anniversary has been set
     */
    public function getAnniversary(): \DateTime|null
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
     * @return \DateTime|null Default anniversary value or null if no default value is available
     */
    public function getDefaultAnniversary(): \DateTime|null
    {
        return null;
    }
}
