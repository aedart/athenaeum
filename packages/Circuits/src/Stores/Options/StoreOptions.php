<?php

namespace Aedart\Circuits\Stores\Options;

use Aedart\Contracts\Circuits\Failures\Factory as FailureFactory;
use Aedart\Contracts\Circuits\States\Factory as StateFactory;

/**
 * Store Options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Stores
 */
class StoreOptions
{
    /**
     * State factory
     *
     * @var StateFactory|null
     */
    public ?StateFactory $stateFactory = null;

    /**
     * Failure factory
     *
     * @var FailureFactory|null
     */
    public ?FailureFactory $failureFactory = null;

    /**
     * Options
     *
     * @var array
     */
    public array $options = [];

    /**
     * StoreOptions constructor.
     *
     * @param array $options [optional]
     * @param StateFactory|null $stateFactory [optional]
     * @param FailureFactory|null $failureFactory [optional]
     */
    public function __construct(
        array $options = [],
        ?StateFactory $stateFactory = null,
        ?FailureFactory $failureFactory = null
    ) {
        $this->options = $options;
        $this->stateFactory = $stateFactory;
        $this->failureFactory = $failureFactory;
    }
}
