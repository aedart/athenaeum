<?php

namespace Aedart\Contracts\Circuits\Exceptions;

use Aedart\Contracts\Circuits\CircuitBreaker;

/**
 * Unable To Change State Exception
 *
 * Should be thrown when a circuit breaker is requested to change state,
 * yet unable to.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Exceptions
 */
interface UnableToChangeStateException extends CircuitBreaker
{
}
