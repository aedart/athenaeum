<?php

namespace Aedart\Circuits\Events;

use Aedart\Contracts\Circuits\Events\HasOpened;

/**
 * State Changed To Open Event
 *
 * @see \Aedart\Contracts\Circuits\Events\HasOpened
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Events
 */
class ChangedToOpen extends BaseEvent implements HasOpened
{

}
