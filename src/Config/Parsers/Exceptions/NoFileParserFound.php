<?php

namespace Aedart\Config\Parsers\Exceptions;

use Aedart\Contracts\Config\Parsers\Exceptions\NoFileParserFoundException;
use RuntimeException;

/**
 * No File Parser Found Exception
 *
 * @see \Aedart\Contracts\Config\Parsers\Exceptions\NoFileParserFoundException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Exceptions
 */
class NoFileParserFound extends RuntimeException implements NoFileParserFoundException
{

}
