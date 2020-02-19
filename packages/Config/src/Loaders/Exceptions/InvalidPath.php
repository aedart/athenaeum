<?php

namespace Aedart\Config\Loaders\Exceptions;

use Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException;
use RuntimeException;

/**
 * Invalid Path Exception
 *
 * @see \Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Loaders\Exceptions
 */
class InvalidPath extends RuntimeException implements InvalidPathException
{
}
