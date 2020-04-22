<?php

namespace Aedart\Contracts\Circuits;

use Aedart\Contracts\Circuits\Exceptions\UnableToChangeStateException;
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
    public function retryAmount(): int ;

    /**
     * Set the name
     *
     * @param string $service E.g. name of 3rd party service or action this
     *                        circuit breaker is handling
     *
     * @return self
     */
    public function name(string $service): self;

    /**
     * Returns the name
     *
     * @return string E.g. name of 3rd party service or action this
     *                circuit breaker is handling
     */
    public function getName(): string;

    /**
     * Returns the last reason for failure, if available
     *
     * @see reportFailure
     *
     * @return string|null
     */
    public function lastFailure(): ?string;

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
