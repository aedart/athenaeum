<?php

namespace Aedart\Contracts\Circuits;

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
     * @param State $state
     *
     * @return bool True if successful, false otherwise
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
     * Report a failure
     *
     * Method MUST increment failures count, using {@see incrementFailures},
     * when a failure is registered.
     *
     * @param Failure $failure
     *
     * @return self
     */
    public function reportFailure(Failure $failure): self;

    /**
     * Returns last registered failure reason, if available
     *
     * @return Failure|null
     */
    public function lastReportedFailure(): ?Failure;

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
    public function amountFailures(): int;

    /**
     * Reset amount of registered failures
     *
     * @return self
     */
    public function resetFailures(): self;
}
