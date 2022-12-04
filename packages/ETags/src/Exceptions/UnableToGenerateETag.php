<?php

namespace Aedart\ETags\Exceptions;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use RuntimeException;

/**
 * Unable To Generate Etag Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Exceptions
 */
class UnableToGenerateETag extends RuntimeException implements ETagGeneratorException
{
}
