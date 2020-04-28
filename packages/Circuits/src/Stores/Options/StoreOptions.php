<?php

namespace Aedart\Circuits\Stores\Options;

use Aedart\Contracts\Circuits\Failures\Factory as FailureFactory;
use Aedart\Contracts\Circuits\States\Factory as StateFactory;
use Illuminate\Contracts\Events\Dispatcher;

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
     * Event dispatcher
     *
     * @var Dispatcher|null
     */
    public ?Dispatcher $dispatcher = null;

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
     * @param Dispatcher|null $dispatcher
     */
    public function __construct(
        array $options = [],
        ?StateFactory $stateFactory = null,
        ?FailureFactory $failureFactory = null,
        ?Dispatcher $dispatcher = null
    ) {
        $this->options = $options;
        $this->stateFactory = $stateFactory;
        $this->failureFactory = $failureFactory;
        $this->dispatcher = $dispatcher;
    }
}
