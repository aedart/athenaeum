<?php

namespace Aedart\Circuits;

use Aedart\Circuits\Exceptions\ServiceUnavailable;
use Aedart\Circuits\Traits\FailureFactoryTrait;
use Aedart\Circuits\Traits\StateFactoryTrait;
use Aedart\Circuits\Traits\StoreTrait;
use Aedart\Contracts\Circuits\CircuitBreaker as CircuitBreakerInterface;
use Aedart\Contracts\Circuits\Exceptions\HasContext;
use Aedart\Contracts\Circuits\Exceptions\StateCannotBeLockedException;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\Failures\FailureFactoryAware;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\StateFactoryAware;
use Aedart\Contracts\Circuits\Store;
use Aedart\Contracts\Circuits\Stores\StoreAware;
use DateTimeInterface;
use Throwable;

/**
 * Circuit Breaker
 *
 * @see \Aedart\Contracts\Circuits\CircuitBreaker
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class CircuitBreaker implements
    CircuitBreakerInterface,
    StoreAware,
    StateFactoryAware,
    FailureFactoryAware
{
    use StoreTrait;
    use StateFactoryTrait;
    use FailureFactoryTrait;
    use Concerns\Dates;
    use Concerns\Options;

    /**
     * Circuit breaker's name
     *
     * @var string
     */
    protected string $name;

    /**
     * Maximum amount of retries
     *
     * @var int
     */
    protected int $retryTimes = 1;

    /**
     * Amount of milliseconds to wait before each attempt
     *
     * @var int
     */
    protected int $retryDelay = 100;

    /**
     * Maximum amount of failures before circuit breaker
     * must trip; change state to {@see static::OPEN}
     *
     * @var int
     */
    protected int $threshold = 1;

    /**
     * A state's time-to-live (ttl)
     *
     *
     * @var int|null Duration in seconds. Null if disabled
     */
    protected int|null $stateTtl = 60;

    /**
     * Grace period duration in seconds
     *
     * @var int
     */
    protected int $gracePeriod = 10;

    /**
     * The default otherwise callback
     *
     * @var callable|null
     */
    protected $otherwise = null;

    /**
     * CircuitBreaker constructor.
     *
     * @param string $service
     * @param array $options [optional]
     */
    public function __construct(string $service, array $options = [])
    {
        $this
            ->setName($service)
            ->withOptions($options)
            ->prepareFromOptions();
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function isAvailable(): bool
    {
        return $this->isStateAvailable($this->state());
    }

    /**
     * @inheritDoc
     *
     * @throws UnknownStateException
     */
    public function reportSuccess(): static
    {
        // Reset last known failures
        $this->store()->reset();

        // Change to closed state
        $this->changeState(
            $this->makeState(static::CLOSED)
        );

        return $this;
    }

    /**
     * @inheritDoc
     *
     * @throws UnknownStateException
     */
    public function reportFailure(Failure $failure): static
    {
        // Register failure (increases failure count)
        $this->store()->registerFailure($failure);

        // Abort if threshold isn't reached
        if (!$this->isFailureThresholdReached()) {
            return $this;
        }

        // Otherwise, we have to change open state
        return $this->trip();
    }

    /**
     * @inheritDoc
     *
     * @throws UnknownStateException
     */
    public function reportFailureViaException(Throwable $exception): static
    {
        $context = [];
        if ($exception instanceof HasContext) {
            $context = $exception->context();
        }

        $failure = $this->getFailureFactory()->make(
            $exception->getMessage(),
            $context,
            $this->now(),
            $this->totalFailures()
        );

        return $this->reportFailure($failure);
    }

    /**
     * @inheritDoc
     *
     * @throws UnknownStateException
     * @throws StateCannotBeLockedException
     */
    public function attempt(callable $callback, callable|null $otherwise = null): mixed
    {
        $otherwise = $otherwise ?? $this->getOtherwise();
        $state = $this->state();
        $available = $this->isStateAvailable($state);

        // When circuit is tripped, it becomes unavailable. Then we must attempt
        // to change the state to half-open, if a grace period has past.
        if (!$available && $this->hasGracePeriodPast($state)) {
            return $this->tryHalfOpen($state, $callback, $otherwise);
        }

        // When unavailable (state is open and unable to chance state to half-open),
        // the otherwise callback must be invoked.
        if (!$available) {
            return $this->invokeCallback($otherwise);
        }

        // Finally, perform the attempt (state is closed or half-open).
        return $this->performAttempt($callback, $otherwise);
    }

    /**
     * @inheritDoc
     */
    public function otherwise(callable|null $otherwise = null): static
    {
        $this->otherwise = $otherwise;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOtherwise(): callable
    {
        return $this->otherwise ?? $this->defaultOtherwiseCallback();
    }

    /**
     * @inheritDoc
     */
    public function retry(int $times, int $delay = 0): static
    {
        $this->retryTimes = $times;
        $this->retryDelay = $delay;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function times(): int
    {
        return $this->retryTimes;
    }

    /**
     * @inheritDoc
     */
    public function retryDelay(): int
    {
        return $this->retryDelay;
    }

    /**
     * @inheritDoc
     */
    public function lastFailure(): Failure|null
    {
        return $this->store()->getFailure();
    }

    /**
     * @inheritDoc
     */
    public function totalFailures(): int
    {
        return $this->store()->totalFailures();
    }

    /**
     * @inheritDoc
     */
    public function isFailureThresholdReached(): bool
    {
        return $this->totalFailures() >= $this->failureThreshold();
    }

    /**
     * @inheritDoc
     */
    public function withFailureThreshold(int $amount): static
    {
        $this->threshold = $amount;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function failureThreshold(): int
    {
        return $this->threshold;
    }

    /**
     * {@inheritDoc}
     *
     * @throws UnknownStateException
     */
    public function trip(): static
    {
        // Change state to open
        $this->changeState(
            $this->makeState(static::OPEN)
        );

        // Register a grace period time measurement
        return $this->startGracePeriod();
    }

    /**
     * @inheritDoc
     */
    public function withGracePeriod(int $seconds): static
    {
        $this->gracePeriod = $seconds;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function gracePeriod(): int
    {
        return $this->gracePeriod;
    }

    /**
     * @inheritDoc
     */
    public function isClosed(): bool
    {
        return $this->state()->id() === static::CLOSED;
    }

    /**
     * @inheritDoc
     */
    public function isOpen(): bool
    {
        return $this->state()->id() === static::OPEN;
    }

    /**
     * @inheritDoc
     */
    public function isHalfOpen(): bool
    {
        return $this->state()->id() === static::HALF_OPEN;
    }

    /**
     * @inheritDoc
     */
    public function state(): State
    {
        return $this->store()->getState();
    }

    /**
     * @inheritDoc
     */
    public function changeState(State $newState): bool
    {
        return $this->store()->setState($newState);
    }

    /**
     * @inheritDoc
     */
    public function store(): Store
    {
        return $this->getStore();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Prepare circuit breaker, set its properties according
     * to received options
     */
    protected function prepareFromOptions()
    {
        $this->timezone = $this->getOption('timezone', $this->timezone);
        $this->stateTtl = $this->getOption('state_ttl', $this->stateTtl);

        $this
            ->retry(
                $this->getOption('retries', $this->times()),
                $this->getOption('delay', $this->retryDelay())
            )
            ->withFailureThreshold(
                $this->getOption('failure_threshold', $this->failureThreshold()),
            )
            ->withGracePeriod(
                $this->getOption('grace_period', $this->gracePeriod()),
            );
    }

    /**
     * Perform attempt
     *
     * Method retries certain amount of times, before invoking
     * `$otherwise` callback.
     *
     * Reports success, if `$callback` succeeds, otherwise method
     * will report failure.
     *
     * @param  callable  $callback
     * @param  callable  $otherwise
     *
     * @return mixed
     *
     * @throws UnknownStateException
     */
    protected function performAttempt(callable $callback, callable $otherwise): mixed
    {
        $delay = $this->retryDelay() * 1000;
        $times = $this->times();

        beginning:
        $times--;

        try {
            $result = $this->invokeCallback($callback);
            $this->reportSuccess();

            return $result;
        } catch (Throwable $e) {
            // Report failure and retry, until it succeeds,
            // run out of retries, or the state has changed to open.
            $this->reportFailureViaException($e);

            if ($times < 1 || $this->isOpen()) {
                return $this->invokeCallback($otherwise);
            }

            if ($delay) {
                usleep($delay);
            }

            // Retry...
            goto beginning;
        }
    }

    /**
     * Tries to change state to {@see CircuitBreakerInterface::HALF_OPEN} and execute
     * given callback.
     *
     * If unable to change state, the `$otherwise` callback is invoked.
     *
     * @param State $state Current state
     * @param callable $callback
     * @param callable $otherwise
     *
     * @return mixed
     *
     * @throws UnknownStateException
     * @throws StateCannotBeLockedException
     */
    protected function tryHalfOpen(State $state, callable $callback, callable $otherwise): mixed
    {
        $halfOpen = $this->makeState(static::HALF_OPEN, $state);
        $wasLocked = false;

        $result = $this->store()->lockState($halfOpen, function () use (&$wasLocked, $callback, $otherwise) {
            // When reached here, it means that we have successfully change state to half-open.
            // Thus, we retry to invoke the callback.
            $wasLocked = true;

            return $this->performAttempt($callback, $otherwise);
        });

        // Invoke the otherwise callback, if unable to obtain lock
        if (!$wasLocked) {
            return $this->invokeCallback($otherwise);
        }

        return $result;
    }

    /**
     * Set this circuit breaker's name
     *
     * @param string $name
     *
     * @return self
     */
    protected function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Determine if state is available ({@see static::CLOSED} or {@see static::HALF_OPEN})
     *
     * @param State $state
     *
     * @return bool
     */
    protected function isStateAvailable(State $state): bool
    {
        $id = $this->state()->id();

        return $id === static::CLOSED || $id === static::HALF_OPEN;
    }

    /**
     * Invokes given callback
     *
     * @param callable $callback
     *
     * @return mixed Resulting output of callback
     */
    protected function invokeCallback(callable $callback): mixed
    {
        return $callback($this);
    }

    /**
     * Returns a default "otherwise" callback
     *
     * @see attempt
     *
     * @return callable
     */
    protected function defaultOtherwiseCallback(): callable
    {
        return function () {
            throw ServiceUnavailable::make(
                $this->name(),
                $this->state(),
                $this->lastFailure()
            );
        };
    }

    /**
     * Starts measuring a "grace period" (time past)
     *
     * @return self
     */
    protected function startGracePeriod(): static
    {
        $this->getStore()->startGracePeriod(
            $this->gracePeriod()
        );

        return $this;
    }

    /**
     * Determine if a grace period has past
     *
     * @param State $current Current state
     *
     * @return bool
     */
    protected function hasGracePeriodPast(State $current): bool
    {
        if ($current->id() !== static::OPEN) {
            return false;
        }

        return $this->getStore()->hasGracePeriodPast();
    }

    /**
     * Creates a new state instance
     *
     * @param int $id State identifier
     * @param State|null $previous [optional] Resolves to current state if none given
     *
     * @return State
     *
     * @throws UnknownStateException
     */
    protected function makeState(int $id, State|null $previous = null): State
    {
        $previous = $previous ?? $this->state();

        return $this->getStateFactory()->make(
            $id,
            $previous->id(),
            $this->now(),
            $this->resolveStateExpiresAt()
        );
    }

    /**
     * Resolves a date's expires at
     *
     * @return DateTimeInterface|null
     */
    protected function resolveStateExpiresAt(): DateTimeInterface|null
    {
        if (!isset($this->stateTtl)) {
            return null;
        }

        return $this->futureDate($this->stateTtl);
    }
}
