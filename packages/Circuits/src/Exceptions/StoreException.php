<?php

namespace Aedart\Circuits\Exceptions;

use Aedart\Contracts\Circuits\Exceptions\StoreException as StoreExceptionInterface;

/**
 * Store Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Exceptions
 */
class StoreException extends CircuitBreakerException implements StoreExceptionInterface
{
}
