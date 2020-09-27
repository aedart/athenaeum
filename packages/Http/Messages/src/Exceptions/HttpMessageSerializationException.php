<?php

namespace Aedart\Http\Messages\Exceptions;

use Aedart\Contracts\Http\Messages\Exceptions\SerializationException;
use RuntimeException;

/**
 * Http Message Serialization Exception
 *
 * @see \Aedart\Contracts\Http\Messages\Exceptions\SerializationException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Exceptions
 */
class HttpMessageSerializationException extends RuntimeException implements SerializationException
{
}
