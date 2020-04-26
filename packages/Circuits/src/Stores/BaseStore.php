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

    /**
     * BaseStore constructor.
     *
     * @param StatesFactory|null $statesFactory [optional]
     * @param FailureFactory|null $failureFactory [optional]
     */
    public function __construct(
        ?StatesFactory $statesFactory = null,
        ?FailureFactory $failureFactory = null
    ) {
        $this
            ->setStateFactory($statesFactory)
            ->setFailureFactory($failureFactory);
    }
}
