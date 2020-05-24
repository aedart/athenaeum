<?php

namespace Aedart\Circuits\Exceptions;

use Aedart\Contracts\Circuits\Exceptions\StateCannotBeLockedException;

/**
 * State Cannot Be Locked Exception
 *
 * @see \Aedart\Contracts\Circuits\Exceptions\StateCannotBeLockedException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Exceptions
 */
class StateCannotBeLocked extends StoreException implements StateCannotBeLockedException
{
}
