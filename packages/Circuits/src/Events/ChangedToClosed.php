<?php

namespace Aedart\Circuits\Events;

use Aedart\Contracts\Circuits\Events\HasClosed;

/**
 * State Changed To Closed Event
 *
 * @see \Aedart\Contracts\Circuits\Events\HasClosed
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Events
 */
class ChangedToClosed extends BaseEvent implements HasClosed
{
}
