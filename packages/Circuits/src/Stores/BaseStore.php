<?php

namespace Aedart\Circuits\Stores;

use Aedart\Circuits\Concerns;
use Aedart\Circuits\Traits\FailureFactoryTrait;
use Aedart\Circuits\Traits\StateFactoryTrait;
use Aedart\Contracts\Circuits\Failures\Factory as FailureFactory;
use Aedart\Contracts\Circuits\Failures\FailureFactoryAware;
use Aedart\Contracts\Circuits\States\Factory as StatesFactory;
use Aedart\Contracts\Circuits\States\StateFactoryAware;
use Aedart\Contracts\Circuits\Store;

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
            ->setFailureFactory($options->failureFactory);
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
}
