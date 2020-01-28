<?php

namespace Aedart\Contracts\Exceptions;

use Throwable;

/**
 * Unsupported Operation Exception
 *
 * Should be thrown when an operation is not supported.
 *
 * This is most likely the ugliest exception you can ever throw.
 * If possible, avoid using this - try to design your solution in a way
 * where this type of exception is not required.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Exceptions
 */
interface UnsupportedOperationException extends Throwable
{

}
