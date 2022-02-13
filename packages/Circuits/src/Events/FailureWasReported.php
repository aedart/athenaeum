<?php

namespace Aedart\Circuits\Events;

use Aedart\Contracts\Circuits\Events\FailureReported;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\State;

/**
 * Failure Was Reported Event
 *
 * @see \Aedart\Contracts\Circuits\Events\FailureReported
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Events
 */
class FailureWasReported extends BaseEvent implements FailureReported
{
    /**
     * The reported failure
     *
     * @var Failure
     */
    public Failure $failure;

    /**
     * Creates new instance of the failure that was reported event
     *
     * @param  State  $state
     * @param  Failure  $failure The reported failure
     * @param  Failure|null  $lastFailure  [optional]
     */
    public function __construct(State $state, Failure $failure, Failure|null $lastFailure = null)
    {
        parent::__construct($state, $lastFailure);

        $this->failure = $failure;
    }

    /**
     * @inheritDoc
     */
    public function failure(): Failure
    {
        return $this->failure;
    }
}
