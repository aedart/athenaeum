<?php

namespace Aedart\Circuits\Stores\Options;

use Aedart\Contracts\Circuits\Failures\Factory as FailureFactory;
use Aedart\Contracts\Circuits\States\Factory as StateFactory;
use Illuminate\Contracts\Cache\Factory;

/**
 * Cache Store Options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Stores\Options
 */
class CacheStoreOptions extends StoreOptions
{
    /**
     * Cache Factory
     *
     * @var Factory|null
     */
    public ?Factory $cacheFactory = null;

    /**
     * {@inheritDoc}
     *
     * @param Factory|null $cacheFactory [optional]
     */
    public function __construct(
        array $options = [],
        ?StateFactory $stateFactory = null,
        ?FailureFactory $failureFactory = null,
        ?Factory $cacheFactory = null
    ) {
        parent::__construct($options, $stateFactory, $failureFactory);

        $this->cacheFactory = $cacheFactory;
    }
}
