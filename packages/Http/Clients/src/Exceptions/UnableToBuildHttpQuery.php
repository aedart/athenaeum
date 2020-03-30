<?php

namespace Aedart\Http\Clients\Exceptions;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use RuntimeException;

/**
 * Unable To Build Http Query Exception
 *
 * Should be thrown when unable to assemble / build a http query
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Exceptions
 */
class UnableToBuildHttpQuery extends RuntimeException implements HttpQueryBuilderException
{
}
