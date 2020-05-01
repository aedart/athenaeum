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
    public function reportSuccess(): self;

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
    public function reportFailure(Failure $failure): self;

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
    public function reportFailureViaException(Throwable $exception): self;

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
     * @see mustTripOn
     * @see times
     * @see retryDelay
     *
     * @param callable $callback Request or action to invoke on 3rd party service
     * @param callable|null $otherwise [optional] This callback is invoked if state is {@see OPEN}
     *                      or if `$callback` fails.
     *
     * @return mixed Callback's resulting output. If `$otherwise` callback is provided,
     *               and it is invoked, then it's resulting output is returned.
     *
     * @throws ServiceUnavailableException If state is {@see OPEN} and no `$otherwise` callback provided
     */
    public function attempt(callable $callback, ?callable $otherwise = null);

    /**
     * Set the maximum amount of times that a callback should
     * be attempted
     *
     * @param int $times
     * @param int $delay [optional] Milliseconds to wait before each try
     *
     * @return self
     */
    public function retry(int $times, int $delay = 0): self;

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
    public function lastFailure(): ?Failure;

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
     * Determine when this circuit breaker should trip, e.g. when
     * it must change it's state to {@see OPEN}.
     *
     * Method accepts class path to one or multiple exceptions.
     * If {@see attempt} method's `$callback` fails with given exception(s),
     * then it will be reported via {@see reportFailure}.
     *
     * If {@see attempt} method's `$callback` should fail with an exception other
     * than those stated here (e.g. not instance of check), then it will NOT be
     * reported as a failure - rather it's interpreted as implementation error.
     *
     * @see attempt
     * @see tripsOn
     *
     * @param string|string[] $exceptions Exception class path or list of class paths
     *
     * @return self
     */
    public function mustTripOn($exceptions = Throwable::class): self;

    /**
     * Returns list of exception class paths, which will
     * cause this circuit breaker to trip
     *
     * @see mustTripOn
     *
     * @return string[] Exception class paths
     */
    public function tripsOn(): array;

    /**
     * Trip this circuit breaker
     *
     * Method must change state to {@see OPEN}
     * 
     * @return self
     */
    public function trip(): self;

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
