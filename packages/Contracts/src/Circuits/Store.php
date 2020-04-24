<?php

namespace Aedart\Contracts\Circuits;

use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\States\Locked;

/**
 * Circuit Breaker Store
 *
 * Keeps track of a circuit breaker's state and amount of
 * failures.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits
 */
interface Store
{
    /**
     * Set circuit breaker's state
     *
     * If given state inherits from {@see Locked}, method
     * SHOULD (implementation specific) attempt to lock
     * the state, so that other instances are NOT able to
     * set / obtain given state.
     *
     * @param State $state
     *
     * @return bool True if successful, false otherwise
     *
     * @throws UnknownStateException
     */
    public function setState(State $state): bool;

    /**
     * Returns circuit breaker's state
     *
     * If no state is available, e.g. if none previously set,
     * then this method MUST return a {@see CircuitBreaker::CLOSED} state
     *
     * @return State
     */
    public function getState(): State;

    /**
     * Set last detected failure
     *
     * Method MUST increment failures count, using {@see incrementFailures},
     * when a failure is registered.
     *
     * @param Failure $failure
     *
     * @return self
     */
    public function setFailure(Failure $failure): self;

    /**
     * Returns last detected failure, if available
     *
     * @return Failure|null
     */
    public function getFailure(): ?Failure;

    /**
     * Increment amount of failures
     *
     * @param int $amount
     *
     * @return int The total amount of failures
     */
    public function incrementFailures(int $amount = 1): int;

    /**
     * Returns amount of registered failures
     *
     * @return int
     */
    public function totalFailures(): int;

    /**
     * Reset last detected failure and total amount
     * of failures
     *
     * @return self
     */
    public function resetFailures(): self;
}
