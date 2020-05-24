<?php

namespace Aedart\Contracts\Circuits\Exceptions;

use Aedart\Contracts\Circuits\CircuitBreaker;

/**
 * Service Unavailable Exception
 *
 * Should be thrown whenever a circuit breaker is not available, e.g.
 * it's state is {@see CircuitBreaker::OPEN}, yet a service resource or
 * action is attempted executed.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Circuits\Exceptions
 */
interface ServiceUnavailableException extends CircuitBreakerException
{
}
