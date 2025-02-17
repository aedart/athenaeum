<?php

namespace Aedart\Support\Properties\Dates;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Expires at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Dates\ExpiresAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Dates
 */
trait ExpiresAtTrait
{
    /**
     * Date of when this component, entity or resource is going to expire
     *
     * @var \DateTimeInterface|null
     */
    protected \DateTimeInterface|null $expiresAt = null;

    /**
     * Set expires at
     *
     * @param \DateTimeInterface|null $date Date of when this component, entity or resource is going to expire
     *
     * @return self
     */
    public function setExpiresAt(\DateTimeInterface|null $date): static
    {
        $this->expiresAt = $date;

        return $this;
    }

    /**
     * Get expires at
     *
     * If no expires at value set, method
     * sets and returns a default expires at.
     *
     * @see getDefaultExpiresAt()
     *
     * @return \DateTimeInterface|null expires at or null if no expires at has been set
     */
    public function getExpiresAt(): \DateTimeInterface|null
    {
        if (!$this->hasExpiresAt()) {
            $this->setExpiresAt($this->getDefaultExpiresAt());
        }
        return $this->expiresAt;
    }

    /**
     * Check if expires at has been set
     *
     * @return bool True if expires at has been set, false if not
     */
    public function hasExpiresAt(): bool
    {
        return isset($this->expiresAt);
    }

    /**
     * Get a default expires at value, if any is available
     *
     * @return \DateTimeInterface|null Default expires at value or null if no default value is available
     */
    public function getDefaultExpiresAt(): \DateTimeInterface|null
    {
        return null;
    }
}
