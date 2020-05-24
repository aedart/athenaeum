<?php

namespace Aedart\Circuits\Events;

use Aedart\Contracts\Circuits\Events\HasHalfOpened;

/**
 * State Changed To Half Open Event
 *
 * @see \Aedart\Contracts\Circuits\Events\HasHalfOpened
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Events
 */
class ChangedToHalfOpen extends BaseEvent implements HasHalfOpened
{
}
