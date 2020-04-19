<?php

namespace Aedart\Contracts\Circuits;

use Aedart\Contracts\Circuits\Exceptions\UnableToChangeStateException;

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
     *
     * The success state - the circuit breaker has
     * not reached it's failure threshold.
     */
    public const CLOSED = 0;

    /**
     * Open state identifier
     *
     * This is the failure state - the circuit breaker has
     * tripped, because the failure threshold has been reached.
     */
    public const OPEN = 2;

    /**
     * Half-open state identifier
     *
     * In this state, a single request (or action) is attempted.
     * If that request or action succeeds, then the state must
     * be changed to {@see CLOSED}, otherwise the state must
     * change back to {@see OPEN}.
     */
    public const HALF_OPEN = 4;

    /**
     * Determine if the service is available
     *
     * Method returns true if the circuit breaker's state is {@see CLOSED}.
     * It MAY return true if state is {@see HALF_OPEN} - yet this is left to
     * actual implementation.
     *
     * @return bool
     */
    public function isAvailable(): bool;

    /**
     * Change circuit breaker's state to {@see CLOSED}
     *
     * This method SHOULD only be used when a request or action has
     * succeeded.
     *
     * Upon successful state change, this method MUST reset internal
     * failure count.
     *
     * @see attemptStateChange
     * @see changeState
     *
     * @return self
     */
    public function reportSuccess(): self;

    /**
     * Increments internal failure count.
     *
     * Method MUST change the state to {@see OPEN}, if the internal
     * failure count reaches the failure threshold.
     *
     * @see lastFailure
     * @see attemptStateChange
     * @see changeState
     *
     * @param string|int $reason [optional] Failure reason
     *
     * @return self
     */
    public function reportFailure(?string $reason = null): self;

    /**
     * Returns the last reason for failure, if available
     *
     * @see reportFailure
     *
     * @return string|null
     */
    public function lastFailure(): ?string;

    /**
     * Determine if Circuit Breaker is in {@see CLOSED} state
     *
     * @return bool
     */
    public function isClosed(): bool;

    /**
     * Determine if Circuit Breaker is in {@see OPEN} state
     *
     * @return bool
     */
    public function isOpen(): bool;

    /**
     * Determine if Circuit Breaker is in {@see HALF_OPEN} state
     *
     * @return bool
     */
    public function isHalfOpen(): bool;

    /**
     * Returns the current state
     *
     * @return int
     */
    public function state(): int;

    /**
     * Change Circuit Breaker state
     *
     * @see attemptStateChange
     *
     * @param int $newState
     *
     * @return self
     *
     * @throws UnableToChangeStateException
     */
    public function changeState(int $newState): self;

    /**
     * Attempt to change the circuit breaker's state
     *
     * @see changeState
     *
     * @param int $newState
     *
     * @return bool True if state changed, false otherwise
     */
    public function attemptStateChange(int $newState): bool;
}
