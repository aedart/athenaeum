<?php


namespace Aedart\Contracts\Circuits;

/**
 * Circuit Breaker
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits
 */
interface CircuitBreaker
{
    /**
     * Closed state identifier - initial state
     */
    public const CLOSED = 0;

    /**
     * Open state identifier
     */
    public const OPEN = 2;

    /**
     * Half-open state identifier
     */
    public const HALF_OPEN = 4;

    /**
     * Determine if Circuit Breaker is in closed state
     *
     * @return bool
     */
    public function isClosed(): bool;

    /**
     * Determine if Circuit Breaker is in open state
     *
     * @return bool
     */
    public function isOpen(): bool;

    /**
     * Determine if Circuit Breaker is in half-open state
     *
     * @return bool
     */
    public function isHalfOpen(): bool;

    /**
     * Returns the current state
     *
     * @return int
     */
    public function state() : int;

    /**
     * Change Circuit Breaker state
     *
     * @param int $newState
     *
     * @return self
     */
    public function changeState(int $newState): self;
}
