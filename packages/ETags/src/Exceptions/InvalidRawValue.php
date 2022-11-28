<?php

namespace Aedart\ETags\Exceptions;

use Aedart\Contracts\ETags\Exceptions\ETagException;
use RuntimeException;

/**
 * Invalid Raw Value Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Exceptions
 */
class InvalidRawValue extends RuntimeException implements ETagException
{
}