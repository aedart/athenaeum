<?php

namespace Aedart\Config\Parsers\Exceptions;

use Aedart\Contracts\Config\Parsers\Exceptions\FileDoesNotExistException;
use RuntimeException;

/**
 * File Does Not Exist Exception
 *
 * @see \Aedart\Contracts\Config\Parsers\Exceptions\FileDoesNotExistException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Exceptions
 */
class FileDoesNotExist extends RuntimeException implements FileDoesNotExistException
{
}
