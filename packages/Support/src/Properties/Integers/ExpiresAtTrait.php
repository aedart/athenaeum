<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Expires at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\ExpiresAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait ExpiresAtTrait
{
    /**
     * Date of when this component, entity or resource is going to expire
     *
     * @var int|null
     */
    protected int|null $expiresAt = null;

    /**
     * Set expires at
     *
     * @param int|null $date Date of when this component, entity or resource is going to expire
     *
     * @return self
     */
    public function setExpiresAt(int|null $date): static
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
     * @return int|null expires at or null if no expires at has been set
     */
    public function getExpiresAt(): int|null
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
     * @return int|null Default expires at value or null if no default value is available
     */
    public function getDefaultExpiresAt(): int|null
    {
        return null;
    }
}
