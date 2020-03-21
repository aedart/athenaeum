<?php

namespace Aedart\Http\Clients\Exceptions;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidCookieFormatException;
use InvalidArgumentException;

/**
 * Invalid Cookie Format Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Exceptions
 */
class InvalidCookieFormat extends InvalidArgumentException implements InvalidCookieFormatException
{
}
