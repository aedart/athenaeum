<?php

namespace Aedart\Circuits\Exceptions;

use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;

/**
 * Unknown State Exception
 *
 * @see \Aedart\Contracts\Circuits\Exceptions\UnknownStateException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Exceptions
 */
class UnknownState extends CircuitBreakerException implements UnknownStateException
{

}
