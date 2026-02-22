<?php

namespace Aedart\Contracts\Circuits;

use Aedart\Contracts\Circuits\Exceptions\HasContext;
use Aedart\Contracts\Circuits\Exceptions\ServiceUnavailableException;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Throwable;

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
     * not reached its failure threshold.
     */
    public const int CLOSED = 0;

    /**
     * Open state identifier
     *
     * This is the failure state - the circuit breaker has
     * tripped, because the failure threshold has been reached.
     */
    public const int OPEN = 2;

    /**
     * Half-open state identifier
     *
     * In this state, a single request (or action) is attempted.
     * If that request or action succeeds, then the state must
     * be changed to {@see CLOSED}, otherwise the state must
     * change back to {@see OPEN}.
     */
    public const int HALF_OPEN = 4;

    /**
     * Returns the name
     *
     * This name can be used to identify circuit breaker
     *
     * @return string E.g. name of 3rd party service or action this
     *                circuit breaker is handling
     */
    public function name(): string;

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
     * @see changeState
     *
     * @return self
     */
    public function reportSuccess(): static;

    /**
     * Report failure and increments internal failure count.
     *
     * Method MUST change the state to {@see OPEN}, if the internal
     * failure count reaches the failure threshold.
     *
     * @see lastFailure
     * @see changeState
     *
     * @param Failure $failure
     *
     * @return self
     */
    public function reportFailure(Failure $failure): static;

    /**
     * Report a failure via an exception
     *
     * Method MUST create a {@see Failure} instance and use
     * the {@see reportFailure} method to report the failure.
     *
     * @param Throwable $exception If provided exception inherits from {@see HasContext},
     *                             then the failure context is set from exception.
     *
     * @return self
     */
    public function reportFailureViaException(Throwable $exception): static;

    /**
     * Attempt to execute callback, e.g. request a resource or invoke action
     * from 3rd party service.
     *
     * Must invoke `$callback`, if state is {@see CLOSED} or {@see HALF_OPEN}.
     * Must invoke `$otherwise` callback if provided, when state is {@see OPEN}.
     *
     * Whenever a failure is detected, it MUST be reported via {@see reportFailure}.
     * Consequently, the {@see reportSuccess} method MUST be used upon success.
     *
     * @see times
     * @see retryDelay
     *
     * @param callable(static): mixed $callback Request or action to invoke on 3rd party service
     * @param null|callable(static): mixed $otherwise [optional] This callback is invoked if state is {@see OPEN}
     *                      or if `$callback` fails.
     *
     * @return mixed Callback's resulting output. If `$otherwise` callback is provided,
     *               and it is invoked, then it's resulting output is returned.
     *
     * @throws ServiceUnavailableException If state is {@see OPEN} and no `$otherwise` callback provided
     */
    public function attempt(callable $callback, callable|null $otherwise = null): mixed;

    /**
     * Set the default callback to be invoked, when state is {@see OPEN} or
     * if an attempt callback fails, in the {@see attempt} method.
     *
     * This callback is only invoked if not `$otherwise` callback is provided,
     * when {@see attempt} is invoked.
     *
     * @param  null|callable(static): mixed  $otherwise  [optional] Default callback to invoke, if state is {@see OPEN}
     *
     * @return self
     */
    public function otherwise(callable|null $otherwise = null): self;

    /**
     * Returns the default callback to be invoked, when state is {@see OPEN} or
     * if an attempt callback fails, in the {@see attempt} method.
     *
     * @see otherwise
     *
     * @return callable(static): mixed If no default was set, a built-in default callback MUST
     *                  be returned.
     */
    public function getOtherwise(): callable;

    /**
     * Set the maximum amount of times that a callback should
     * be attempted
     *
     * @param int $times
     * @param int $delay [optional] Milliseconds to wait before each try
     *
     * @return self
     */
    public function retry(int $times, int $delay = 0): static;

    /**
     * Returns the maximum amount of times a callback should
     * be attempted
     *
     * @see retry
     *
     * @return int
     */
    public function times(): int;

    /**
     * Returns milliseconds to wait before each try
     *
     * @see retry
     *
     * @return int
     */
    public function retryDelay(): int;

    /**
     * Returns the last reported for failure, if available
     *
     * @see reportFailure
     *
     * @return Failure|null
     */
    public function lastFailure(): Failure|null;

    /**
     * Returns the current amount of failures
     *
     * @return int
     */
    public function totalFailures(): int;

    /**
     * Determine if the failure threshold has been reached
     *
     * @see failureThreshold
     * @see totalFailures
     *
     * @return bool
     */
    public function isFailureThresholdReached(): bool;

    /**
     * Set the failure threshold
     *
     * Failure threshold means the maximum amount of failures,
     * before this circuit breaker trips ~ switches state to
     * {@see OPEN}.
     *
     * @param int $amount
     *
     * @return self
     */
    public function withFailureThreshold(int $amount): self;

    /**
     * Returns the failure threshold
     *
     * @see withFailureThreshold
     *
     * @return int
     */
    public function failureThreshold(): int;

    /**
     * Trip this circuit breaker
     *
     * Method must change state to {@see OPEN} and start
     * a grace period time measurement, if one isn't already
     * started.
     *
     * @return self
     */
    public function trip(): self;

    /**
     * Set the grace period duration
     *
     * A grace period is started whenever circuit breaker is tripped.
     * It is used to determine if circuit breaker can attempt to change
     * state to {@see HALF_OPEN}.
     *
     * @param int $seconds
     *
     * @return self
     */
    public function withGracePeriod(int $seconds): self;

    /**
     * Returns the grace period duration
     *
     * @see withGracePeriod
     *
     * @return int
     */
    public function gracePeriod(): int;

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
     * @return State
     */
    public function state(): State;

    /**
     * Change Circuit Breaker state
     *
     * @param State $newState
     *
     * @return bool True if state changed, false otherwise
     *
     * @throws UnknownStateException
     */
    public function changeState(State $newState): bool;

    /**
     * Returns the store that is responsible for
     * persisting this circuit breaker's state
     *
     * @return Store
     */
    public function store(): Store;
}
