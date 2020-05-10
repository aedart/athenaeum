<?php

namespace Aedart\Circuits;

use Aedart\Circuits\Concerns;
use Aedart\Circuits\Exceptions\ServiceUnavailable;
use Aedart\Circuits\Traits\FailureFactoryTrait;
use Aedart\Circuits\Traits\StateFactoryTrait;
use Aedart\Circuits\Traits\StoreTrait;
use Aedart\Contracts\Circuits\CircuitBreaker as CircuitBreakerInterface;
use Aedart\Contracts\Circuits\Exceptions\HasContext;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\Failures\FailureFactoryAware;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\StateFactoryAware;
use Aedart\Contracts\Circuits\Store;
use Aedart\Contracts\Circuits\Stores\StoreAware;
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
     * CircuitBreaker constructor.
     *
     * @param string $service
     * @param array $options [optional]
     */
    public function __construct(string $service, array $options = [])
    {
        $this
            ->setName($service)
            ->withOptions($options);

        // TODO: Prepare values from options
        // TODO: E.g. set timezone
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
     */
    public function reportSuccess(): CircuitBreakerInterface
    {
        // Create closed state
        $closed = $this->getStateFactory()->make(
            static::CLOSED,
            $this->state()->id(),
            $this->now(),
            // TODO: expires at / a default ttl?
        );

        // Reset last known failures
        $this->store()->resetFailures();

        // Change to closed state
        $this->changeState($closed);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function reportFailure(Failure $failure): CircuitBreakerInterface
    {
        // Register failure (increases failure count)
        $this->store()->registerFailure($failure);

        // Abort if threshold isn't reached
        if (!$this->isFailureThresholdReached()) {
            return $this;
        }

        // Otherwise we have to change open state
        return $this->trip();
    }

    /**
     * @inheritDoc
     */
    public function reportFailureViaException(Throwable $exception): CircuitBreakerInterface
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
     */
    public function attempt(callable $callback, ?callable $otherwise = null)
    {
        $otherwise = $otherwise ?? $this->defaultOtherwiseCallback();
        $state = $this->state();
        $available = $this->isStateAvailable($state);

        // When circuit is tripped, it becomes unavailable and we must attempt
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
    public function retry(int $times, int $delay = 0): CircuitBreakerInterface
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
    public function lastFailure(): ?Failure
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
    public function withFailureThreshold(int $amount): CircuitBreakerInterface
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
    public function trip(): CircuitBreakerInterface
    {
        $open = $this->getStateFactory()->make(
            static::OPEN,
            $this->state()->id(),
            $this->now(),
        // TODO: expires at / a default ttl?
        );

        $this->changeState($open);

        return $this;
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
     * Perform attempt
     *
     * Method retries certain amount of times, before invoking
     * `$otherwise` callback.
     *
     * Reports success, if `$callback` succeeds, otherwise method
     * will report failure.
     *
     * @param callable $callback
     * @param callable $otherwise
     *
     * @return mixed
     */
    protected function performAttempt(callable $callback, callable $otherwise)
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
            // At this point, the captured exception is expected and we will
            // treat it accordingly; report failure and retry, until it succeeds,
            // run out of retries or the state has changed to open.
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

    // TODO:
    protected function tryHalfOpen(State $state, callable $callback, callable $otherwise)
    {
        $halfOpen = $this->getStateFactory()->make(
            static::HALF_OPEN,
            $state->id(),
            $this->now(),
        // TODO: expires at / ttl
        );

        $wasLocked = false;

        $result = $this->store()->lockState($halfOpen, function () use (&$wasLocked, $callback, $otherwise){
            // When reached here, it means that we have successfully change state to half-open.
            // Thus, we retry to invoke the callback.
            $wasLocked = true;

            return $this->performAttempt($callback, $otherwise);
        });

        // Invoke the otherwise callback, if unable to obtain lock
        if(!$wasLocked){
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
    protected function setName(string $name)
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
    protected function invokeCallback(callable $callback)
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
     * Determine if a grace period has past
     *
     * @param State $open Open state
     *
     * @return bool
     */
    protected function hasGracePeriodPast(State $open): bool
    {
        if($open->id() !== static::OPEN){
            return false;
        }

        return $this->getStore()->hasGracePeriodPast();
    }
}
