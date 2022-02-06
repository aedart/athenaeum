<?php

namespace Aedart\Http\Clients\Exceptions;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidStatusCodeException;
use RuntimeException;

/**
 * Invalid Http Status Code Exception
 *
 * @see \Aedart\Contracts\Http\Clients\Exceptions\InvalidStatusCodeException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Exceptions
 */
class InvalidStatusCode extends RuntimeException implements InvalidStatusCodeException
{
}
