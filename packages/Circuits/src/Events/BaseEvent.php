<?php

namespace Aedart\Circuits\Events;

use Aedart\Contracts\Circuits\Events\CircuitBreakerEvent;
use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\State;

/**
 * Base Event
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Events
 */
abstract class BaseEvent implements CircuitBreakerEvent
{
    /**
     * The state
     *
     * @var State
     */
    public State $state;

    /**
     * Last reported failure
     *
     * @var Failure|null
     */
    public ?Failure $lastFailure = null;

    /**
     * BaseEvent constructor.
     *
     * @param State $state
     * @param Failure|null $lastFailure [optional]
     */
    public function __construct(State $state, ?Failure $lastFailure = null)
    {
        $this->state = $state;
        $this->lastFailure = $lastFailure;
    }

    /**
     * @inheritDoc
     */
    public function state(): State
    {
        return $this->state;
    }

    /**
     * @inheritDoc
     */
    public function lastFailure(): ?Failure
    {
        return $this->lastFailure;
    }
}
