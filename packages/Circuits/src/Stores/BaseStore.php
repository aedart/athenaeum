<?php

namespace Aedart\Circuits\Stores;

use Aedart\Circuits\Concerns;
use Aedart\Circuits\Failures\CircuitBreakerFailure;
use Aedart\Circuits\States\ClosedState;
use Aedart\Circuits\States\HalfOpenState;
use Aedart\Circuits\States\OpenState;
use Aedart\Circuits\Stores\Options\StoreOptions;
use Aedart\Circuits\Traits\FailureFactoryTrait;
use Aedart\Circuits\Traits\StateFactoryTrait;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\Failures\FailureFactoryAware;
use Aedart\Contracts\Circuits\State;
use Aedart\Contracts\Circuits\States\StateFactoryAware;
use Aedart\Contracts\Circuits\Store;
use Illuminate\Support\Str;

/**
 * Base Store
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Stores
 */
abstract class BaseStore implements Store,
    StateFactoryAware,
    FailureFactoryAware
{
    use StateFactoryTrait;
    use FailureFactoryTrait;
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
    public function __construct(string $service, StoreOptions $options) {
        $this
            ->setService($service)
            ->withOptions($options->options)
            ->setStateFactory($options->stateFactory)
            ->setFailureFactory($options->failureFactory)
            ->setKeyPrefix($service);
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
}
