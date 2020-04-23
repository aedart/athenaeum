<?php

namespace Aedart\Contracts\Circuits;

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
     * Increments internal failure count.
     *
     * Method MUST change the state to {@see OPEN}, if the internal
     * failure count reaches the failure threshold.
     *
     * @see lastFailure
     * @see changeState
     *
     * @param string|int $reason [optional] Failure reason
     *
     * @return self
     */
    public function reportFailure(?string $reason = null): self;

    /**
     * Attempt to execute callback, e.g. request a resource or invoke action
     * from 3rd party service.
     *
     * If state is {@see CLOSED}, then `$callback` MUST be invoked. Should the
     * callback fail, then the internal failure count will be increased. If
     * internal failure count reaches the failure threshold, method MUST
     * change the state to {@see OPEN} (circuit tripped).
     *
     * If circuit breaker is {@see OPEN}, then `$callback` MUST NOT be invoked. The
     * `$otherwise` callback MUST be invoked, if one is provided. If no `$otherwise`
     * callback is provided, then an exception MUST be raised
     * (fast failure principle).
     *
     * Should the circuit breaker's state be {@see HALF_OPEN}, then `$callback`
     * MUST be invoked. If the callback does not fail, then the state MUST
     * be changed to {@see CLOSED}. Internal failure count and timeouts MUST be
     * reset, if this is the case.
     *
     * Whenever a failure is detected, it MUST be reported via {@see reportFailure}.
     * Consequently, the {@see reportSuccess} method MUST be used upon success.
     *
     * @see mustTripOn
     *
     * @param callable $callback Request or action to invoke on 3rd party service
     * @param callable|null $otherwise [optional] This callback is invoked if state is {@see OPEN}
     *                      or if `$callback` fails. If not provided and `$callback` fails, then an
     *                      exception will be thrown (fast failure principle).
     *
     * @return mixed Callback's resulting output. If `$otherwise` callback is provided,
     *               and it is invoked, then it's resulting output is returned.
     *
     * @throws Throwable
     */
    public function attempt(callable $callback, ?callable $otherwise = null);

    /**
     * Set the amount of retries
     *
     * @param int $amount
     *
     * @return self
     */
    public function retry(int $amount): self;

    /**
     * Returns the amount of retries
     *
     * @return int
     */
    public function retryAmount(): int;

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
     * Returns the last reason for failure, if available
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
    public function amountFailures(): int;

    /**
     * Determine if the failure threshold has been reached
     *
     * @see getFailureThreshold
     * @see amountFailures
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
    public function failureThreshold(int $amount): self;

    /**
     * Returns the failure threshold
     *
     * @see failureThreshold
     *
     * @return int
     */
    public function getFailureThreshold(): int;

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
     */
    public function changeState(State $newState): bool;
}
