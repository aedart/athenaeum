<?php

namespace Aedart\Contracts\Http\Clients\Exceptions;

use Throwable;

/**
 * Invalid Http Status Code Exception
 *
 * Should be thrown whenever an invalid Http status code is given, e.g. negative values,
 * none-numeric values, etc.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Exceptions
 */
interface InvalidStatusCodeException extends Throwable
{
}
