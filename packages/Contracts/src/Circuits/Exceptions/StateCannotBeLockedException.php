<?php


namespace Aedart\Contracts\Circuits\Exceptions;

/**
 * State Cannot Be Locked Exception
 *
 * Should be thrown when an unsupported state is attempted locked.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Exceptions
 */
interface StateCannotBeLockedException extends StoreException
{
}
