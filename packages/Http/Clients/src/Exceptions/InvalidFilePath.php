<?php

namespace Aedart\Http\Clients\Exceptions;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use InvalidArgumentException;

/**
 * Invalid File Path Exception
 *
 * @see \Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Exceptions
 */
class InvalidFilePath extends InvalidArgumentException implements InvalidFilePathException
{
}
