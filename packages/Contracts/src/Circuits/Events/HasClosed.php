<?php

namespace Aedart\Contracts\Circuits\Events;

use Aedart\Contracts\Circuits\CircuitBreaker;

/**
 * Has Closed
 *
 * Should be dispatched immediately after a circuit breaker
 * has changed it's state to {@see CircuitBreaker::CLOSED}.
 *
 * Closed is the success state - initial state
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Events
 */
interface HasClosed extends CircuitBreakerEvent
{
}
