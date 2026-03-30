<?php

namespace Aedart\Contracts\Circuits\Events;

use Aedart\Contracts\Circuits\States\Identifier;

/**
 * Has Closed
 *
 * Should be dispatched immediately after a circuit breaker
 * has changed it's state to {@see Identifier::CLOSED}.
 *
 * Closed is the success state - initial state
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Events
 */
interface HasClosed extends CircuitBreakerEvent
{
}
