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
     * {@inheritDoc}
     *
     * @param Failure $failure The reported failure
     */
    public function __construct(State $state, Failure $failure, ?Failure $lastFailure = null)
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
