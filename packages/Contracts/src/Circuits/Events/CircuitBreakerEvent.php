<?php

namespace Aedart\Contracts\Circuits\Events;

use Aedart\Contracts\Circuits\Failure;
use Aedart\Contracts\Circuits\State;

/**
 * Circuit Breaker Event
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Events
 */
interface CircuitBreakerEvent
{
    /**
     * Returns the state that circuit breaker
     * was, when this event was dispatched
     *
     * @return State
     */
    public function state(): State;

    /**
     * Returns the last reported failure, if available
     *
     * @return Failure|null
     */
    public function lastFailure(): Failure|null;
}
