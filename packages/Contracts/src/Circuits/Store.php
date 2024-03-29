<?php

namespace Aedart\Contracts\Circuits;

use Aedart\Contracts\Circuits\Events\FailureReported;
use Aedart\Contracts\Circuits\Events\HasClosed;
use Aedart\Contracts\Circuits\Events\HasHalfOpened;
use Aedart\Contracts\Circuits\Events\HasOpened;
use Aedart\Contracts\Circuits\Exceptions\StateCannotBeLockedException;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\States\Lockable;

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
     * Upon successful state change, method MUST dispatch
     * appropriate event.
     *
     * @see HasClosed
     * @see HasOpened
     * @see HasHalfOpened
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
     * Attempt to obtain a lock for given state
     *
     * This method is intended for setting intermediate states,
     * e.g. like the {@see CircuitBreaker::HALF_OPEN} state.
     *
     * @param State|Lockable $state Lockable state
     * @param callable $callback Invoked if locked is successfully acquired.
     *                           Once callback has been invoked, the lock MUST
     *                           automatically be released.
     *
     * @return mixed Callback's resulting output or False if lock was not acquired
     *
     * @throws StateCannotBeLockedException If given state cannot be locked, e.g. not
     *                               supported.
     */
    public function lockState(State|Lockable $state, callable $callback): mixed;

    /**
     * Register a detected failure
     *
     * Method MUST increment failures count, using {@see incrementFailures},
     * when a failure is registered.
     *
     * Method MUST dispatch {@see FailureReported} event, upon successful
     * registration of failure.
     *
     * @param Failure $failure
     *
     * @return bool True if successful, false otherwise
     */
    public function registerFailure(Failure $failure): bool;

    /**
     * Returns last detected failure, if available
     *
     * @return Failure|null
     */
    public function getFailure(): Failure|null;

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
     * Starts measuring a "grace period" (time past)
     *
     * Method is intended to be invoked whenever a
     * circuit breaker failure threshold has been
     * reached, and it's state is changed to {@see CircuitBreaker::OPEN}.
     *
     * Method MUST not (re)start time measurement, if
     * a grace period measurement has already been started.
     *
     * @param int $duration Duration of grace period, in seconds
     *
     * @return self
     */
    public function startGracePeriod(int $duration = 10): static;

    /**
     * Determine if a grace period has past
     *
     * A grace period is measured from the time of
     * the first registered failure and until a time
     * interval has past.
     *
     * @return bool
     */
    public function hasGracePeriodPast(): bool;

    /**
     * Reset last detected failure, total amount
     * of failures and grace period time measurement
     *
     * @return self
     */
    public function reset(): static;
}
