<?php

namespace Aedart\Contracts\Utils\Exceptions;

use Throwable;

/**
 * Json Encoding Exception
 *
 * <br />
 *
 * Throw this exception whenever a value cannot be encoded or decoded
 *
 * <br />
 *
 * <b>Note</b>: In the future, this interface will wrap PHP's native Json Exception.
 *
 * @see \JsonException
 * @link https://wiki.php.net/rfc/json_throw_on_error
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils\Exceptions
 */
interface JsonEncodingException extends Throwable
{

}
