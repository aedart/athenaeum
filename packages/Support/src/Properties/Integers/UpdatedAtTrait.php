<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Updated at Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\UpdatedAtAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait UpdatedAtTrait
{
    /**
     * Date of when this component, entity or resource was updated
     *
     * @var int|null
     */
    protected int|null $updatedAt = null;

    /**
     * Set updated at
     *
     * @param int|null $date Date of when this component, entity or resource was updated
     *
     * @return self
     */
    public function setUpdatedAt(int|null $date): static
    {
        $this->updatedAt = $date;

        return $this;
    }

    /**
     * Get updated at
     *
     * If no updated at value set, method
     * sets and returns a default updated at.
     *
     * @see getDefaultUpdatedAt()
     *
     * @return int|null updated at or null if no updated at has been set
     */
    public function getUpdatedAt(): int|null
    {
        if (!$this->hasUpdatedAt()) {
            $this->setUpdatedAt($this->getDefaultUpdatedAt());
        }
        return $this->updatedAt;
    }

    /**
     * Check if updated at has been set
     *
     * @return bool True if updated at has been set, false if not
     */
    public function hasUpdatedAt(): bool
    {
        return isset($this->updatedAt);
    }

    /**
     * Get a default updated at value, if any is available
     *
     * @return int|null Default updated at value or null if no default value is available
     */
    public function getDefaultUpdatedAt(): int|null
    {
        return null;
    }
}
