<?php

namespace Aedart\Http\Clients\Exceptions;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidUriException;
use InvalidArgumentException;

/**
 * Invalid Uri Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Exceptions
 */
class InvalidUri extends InvalidArgumentException implements InvalidUriException
{
}
