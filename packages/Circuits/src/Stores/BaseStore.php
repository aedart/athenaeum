<?php

namespace Aedart\Circuits\Stores;

use Aedart\Circuits\Concerns;
use Aedart\Circuits\Events\ChangedToClosed;
use Aedart\Circuits\Events\ChangedToHalfOpen;
use Aedart\Circuits\Events\ChangedToOpen;
use Aedart\Circuits\Events\FailureWasReported;
use Aedart\Circuits\Failures\CircuitBreakerFailure;
use Aedart\Circuits\States\ClosedState;
use Aedart\Circuits\States\HalfOpenState;
use Aedart\Circuits\States\OpenState;
use Aedart\Circuits\Stores\Options\StoreOptions;
use Aedart\Circuits\Traits\FailureFactoryTrait;
use Aedart\Circuits\Traits\StateFactoryTrait;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Events\CircuitBreakerEvent;
use Aedart\Contracts\Circuits\Events\FailureReported;
use Aedart\Contracts\Circuits\Events\HasClosed;
use Aedart\Contracts\Circuits\Events\HasHalfOpened;
use Aedart\Contracts\Circuits\Events\HasOpened;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\Failures\FailureFactoryAware;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\StateFactoryAware;
use Aedart\Contracts\Circuits\Store;
use Aedart\Contracts\Support\Helpers\Events\DispatcherAware;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

/**
 * Base Store
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Stores
 */
abstract class BaseStore implements
    Store,
    StateFactoryAware,
    FailureFactoryAware,
    DispatcherAware
{
    use StateFactoryTrait;
    use FailureFactoryTrait;
    use DispatcherTrait;
    use Concerns\Options;

    /**
     * Name of service
     *
     * @var string
     */
    protected string $service;

    /**
     * Key prefix
     *
     * @var string
     */
    protected string $keyPrefix = '';

    /**
     * Default state time-to-live
     *
     * @var int Duration in seconds
     */
    protected int $defaultTtl = 3600;

    /**
     * Allowed classes to be unserialized
     *
     * @var string[]
     */
    protected array $allowedClasses = [
        State::class,
//        ClosedState::class,
//        OpenState::class,
//        HalfOpenState::class,
        Failure::class,
//        CircuitBreakerFailure::class
    ];

    /**
     * BaseStore constructor.
     *
     * @param string $service
     * @param StoreOptions $options
     */
    public function __construct(string $service, StoreOptions $options)
    {
        $this
            ->setService($service)
            ->withOptions($options->options)
            ->setStateFactory($options->stateFactory)
            ->setFailureFactory($options->failureFactory)
            ->setDispatcher($options->dispatcher)
            ->setKeyPrefix($service);
    }

    /**
     * Convert, e.g. serialise, value so that store can
     * persist it.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function toStore($value)
    {
        return serialize($value);
    }

    /**
     * Convert, e.g. unserialize, value so store
     * can return it to circuit breaker
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function fromStore($value)
    {
        return unserialize($value, [ 'allowed_classes' => $this->allowedClasses ]);
    }

    /**
     * Returns time-to-live for states
     *
     * @return int Duration in seconds
     */
    public function ttl(): int
    {
        return $this->getOption('ttl', $this->defaultTtl);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Set the service's name
     *
     * @param string $name
     *
     * @return self
     */
    protected function setService(string $name)
    {
        $this->service = $name;

        return $this;
    }

    /**
     * Set key prefix
     *
     * @param string $prefix [optional]
     *
     * @return self
     */
    protected function setKeyPrefix(string $prefix = '')
    {
        $this->keyPrefix = $prefix;

        return $this;
    }

    /**
     * Creates a prefixed key name
     *
     * @param string $name
     *
     * @return string Prefixed key
     */
    protected function key(string $name): string
    {
        return Str::snake($this->keyPrefix . '_' . $name);
    }

    /**
     * Returns the ttl of given state
     *
     * If state does not have en expiration date and time, the
     * method will return a default ttl via {@see ttl} method.
     *
     * @param State $state
     *
     * @return int Duration in seconds
     */
    protected function stateTtl(State $state): int
    {
        $expiresAt = $state->expiresAt();
        if (!isset($expiresAt)) {
            return $this->ttl();
        }

        if ($state->hasExpired()) {
            return 0;
        }

        $diff = $expiresAt->diff(
            Date::now($expiresAt->getTimezone()),
            true
        );

        return (int) $diff->format('%s');
    }

    /**
     * Dispatch "state has changed" event
     *
     * @see HasClosed
     * @see HasOpened
     * @see HasHalfOpened
     *
     * @param State $state
     *
     * @return self
     */
    protected function dispatchStateChange(State $state)
    {
        switch ($state->id()) {
            case CircuitBreaker::CLOSED:
                $event = HasClosed::class;
                $payload = new ChangedToClosed($state, $this->getFailure());
                break;

            case CircuitBreaker::OPEN:
                $event = HasOpened::class;
                $payload = new ChangedToOpen($state, $this->getFailure());
                break;

            case CircuitBreaker::HALF_OPEN:
                $event = HasHalfOpened::class;
                $payload = new ChangedToHalfOpen($state, $this->getFailure());
                break;

            default:
                // N/A -  we could fail here, but might not be suitable
                // when considering that this method is "only" intended to
                // dispatch state change events.
                return $this;
        }

        // Finally, dispatch the event
        return $this->dispatchEvent($event, $payload);
    }

    /**
     * Dispatch a failure was reported {@see CircuitBreaker::CLOSED} event
     *
     * @param Failure $failure
     */
    protected function dispatchFailureReported(Failure $failure)
    {
        $this->dispatchEvent(
            FailureReported::class,
            new FailureWasReported($this->getState(), $failure, $this->getFailure())
        );
    }

    /**
     * Dispatch circuit breaker event
     *
     * @param string $event Identifier
     * @param CircuitBreakerEvent $payload
     *
     * @return self;
     */
    protected function dispatchEvent(string $event, CircuitBreakerEvent $payload)
    {
        $this->getDispatcher()->dispatch($event, $payload);

        return $this;
    }
}
