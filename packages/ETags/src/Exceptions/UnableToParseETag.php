<?php

namespace Aedart\ETags\Exceptions;

use Aedart\Contracts\ETags\Exceptions\ETagException;
use RuntimeException;

/**
 * Unable To Parse Etag Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Exceptions
 */
class UnableToParseETag extends RuntimeException implements ETagException
{
}