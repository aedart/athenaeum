<?php

namespace Aedart\Support\Properties\Integers;

/**
 * Timeout Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\TimeoutAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait TimeoutTrait
{
    /**
     * Timeout amount
     *
     * @var int|null
     */
    protected ?int $timeout = null;

    /**
     * Set timeout
     *
     * @param int|null $amount Timeout amount
     *
     * @return self
     */
    public function setTimeout(?int $amount)
    {
        $this->timeout = $amount;

        return $this;
    }

    /**
     * Get timeout
     *
     * If no "timeout" value set, method
     * sets and returns a default "timeout".
     *
     * @see getDefaultTimeout()
     *
     * @return int|null timeout or null if no timeout has been set
     */
    public function getTimeout() : ?int
    {
        if ( ! $this->hasTimeout()) {
            $this->setTimeout($this->getDefaultTimeout());
        }
        return $this->timeout;
    }

    /**
     * Check if "timeout" has been set
     *
     * @return bool True if "timeout" has been set, false if not
     */
    public function hasTimeout() : bool
    {
        return isset($this->timeout);
    }

    /**
     * Get a default "timeout" value, if any is available
     *
     * @return int|null Default "timeout" value or null if no default value is available
     */
    public function getDefaultTimeout() : ?int
    {
        return null;
    }
}
