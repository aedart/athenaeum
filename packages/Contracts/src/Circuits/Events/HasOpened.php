<?php

namespace Aedart\Contracts\Circuits\Events;

use Aedart\Contracts\Circuits\States\Identifier;

/**
 * Has Opened
 *
 * Should be dispatched immediately after a circuit breaker
 * has changed it's state to {@see Identifier::OPEN}.
 *
 * Open is the failure state - when circuit is tripped.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Events
 */
interface HasOpened extends CircuitBreakerEvent
{
}
