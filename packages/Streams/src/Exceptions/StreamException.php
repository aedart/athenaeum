<?php

namespace Aedart\Streams\Exceptions;

use Aedart\Contracts\Streams\Exceptions\StreamException as StreamExceptionInterface;
use RuntimeException;

/**
 * Stream Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Exceptions
 */
class StreamException extends RuntimeException implements StreamExceptionInterface
{
}
