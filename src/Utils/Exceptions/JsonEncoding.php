<?php

namespace Aedart\Utils\Exceptions;

use Aedart\Contracts\Utils\Exceptions\JsonEncodingException;
use JsonException;

/**
 * @deprecated Since 2.0, use native \JsonException instead
 *
 * Json Encoding Exception
 *
 * <br />
 *
 * Note: In the future, this exception will act as a wrapper for PHP's native
 * Json Exception.
 *
 * @see \JsonException
 * @see \Aedart\Contracts\Utils\Exceptions\JsonEncodingException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Exceptions
 */
class JsonEncoding extends JsonException implements JsonEncodingException
{

}
