<?php


namespace Aedart\Contracts\Circuits\Exceptions;

/**
 * Unknown State Exception
 *
 * Should be thrown whenever an unknown state is attempted set, created
 * or obtained.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Exceptions
 */
interface UnknownStateException extends CircuitBreakerException
{

}
