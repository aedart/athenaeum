<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Status Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\StatusAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait StatusTrait
{
    /**
     * Situation of progress, classification, or civil status
     *
     * @var string|null
     */
    protected string|null $status = null;

    /**
     * Set status
     *
     * @param string|null $status Situation of progress, classification, or civil status
     *
     * @return self
     */
    public function setStatus(string|null $status): static
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
     * @return string|null status or null if no status has been set
     */
    public function getStatus(): string|null
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
     * @return string|null Default status value or null if no default value is available
     */
    public function getDefaultStatus(): string|null
    {
        return null;
    }
}
