<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Timestamp Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\TimestampAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait TimestampTrait
{
    /**
     * Unix timestamp
     *
     * @var int|null
     */
    protected int|null $timestamp = null;

    /**
     * Set timestamp
     *
     * @param int|null $timestamp Unix timestamp
     *
     * @return self
     */
    public function setTimestamp(int|null $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * If no timestamp value set, method
     * sets and returns a default timestamp.
     *
     * @see getDefaultTimestamp()
     *
     * @return int|null timestamp or null if no timestamp has been set
     */
    public function getTimestamp(): int|null
    {
        if (!$this->hasTimestamp()) {
            $this->setTimestamp($this->getDefaultTimestamp());
        }
        return $this->timestamp;
    }

    /**
     * Check if timestamp has been set
     *
     * @return bool True if timestamp has been set, false if not
     */
    public function hasTimestamp(): bool
    {
        return isset($this->timestamp);
    }

    /**
     * Get a default timestamp value, if any is available
     *
     * @return int|null Default timestamp value or null if no default value is available
     */
    public function getDefaultTimestamp(): int|null
    {
        return null;
    }
}
