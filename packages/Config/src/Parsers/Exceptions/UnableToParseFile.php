<?php

namespace Aedart\Config\Parsers\Exceptions;

use Aedart\Contracts\Config\Parsers\Exceptions\FileParserException;
use RuntimeException;

/**
 * Unable To Parse File Exception
 *
 * @see \Aedart\Contracts\Config\Parsers\Exceptions\FileParserException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Exceptions
 */
class UnableToParseFile extends RuntimeException implements FileParserException
{
}
