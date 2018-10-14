<?php

namespace Aedart\Contracts\Config\Parsers\Exceptions;

/**
 * No File Parser Found Exception
 *
 * <br />
 *
 * Throw this exception when a non-existing or unsupported File Parser is requested.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Config\Parsers\Exceptions
 */
interface NoFileParserFoundException extends FileParserException
{

}
