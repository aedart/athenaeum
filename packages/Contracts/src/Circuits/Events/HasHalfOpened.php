<?php

namespace Aedart\Contracts\Circuits\Events;

use Aedart\Contracts\Circuits\CircuitBreaker;

/**
 * Has Half Opened
 *
 * Should be dispatched immediately after a circuit breaker
 * has changed it's state to {@see CircuitBreaker::HALF_OPEN}.
 *
 * Half open is an intermediate state, in which a circuit
 * breaker attempt to change state to {@see CircuitBreaker::CLOSED}.
 * Think of this as a "recovery attempt" state.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Events
 */
interface HasHalfOpened extends CircuitBreakerEvent
{
}
