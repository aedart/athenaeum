<?php

namespace Aedart\Circuits\Exceptions;

use Aedart\Contracts\Circuits\Exceptions\CircuitBreakerException as CircuitBreakerExceptionInterface;
use RuntimeException;

/**
 * Circuit Breaker Exception
 *
 * General exception...
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Exceptions
 */
class CircuitBreakerException extends RuntimeException implements CircuitBreakerExceptionInterface
{

}
