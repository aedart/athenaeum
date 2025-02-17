<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Status Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\StatusAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait StatusTrait
{
    /**
     * Situation of progress, classification, or civil status
     *
     * @var int|null
     */
    protected int|null $status = null;

    /**
     * Set status
     *
     * @param int|null $status Situation of progress, classification, or civil status
     *
     * @return self
     */
    public function setStatus(int|null $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * If no status value set, method
     * sets and returns a default status.
     *
     * @see getDefaultStatus()
     *
     * @return int|null status or null if no status has been set
     */
    public function getStatus(): int|null
    {
        if (!$this->hasStatus()) {
            $this->setStatus($this->getDefaultStatus());
        }
        return $this->status;
    }

    /**
     * Check if status has been set
     *
     * @return bool True if status has been set, false if not
     */
    public function hasStatus(): bool
    {
        return isset($this->status);
    }

    /**
     * Get a default status value, if any is available
     *
     * @return int|null Default status value or null if no default value is available
     */
    public function getDefaultStatus(): int|null
    {
        return null;
    }
}
