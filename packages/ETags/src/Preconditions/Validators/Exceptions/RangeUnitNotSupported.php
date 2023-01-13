<?php

namespace Aedart\ETags\Preconditions\Validators\Exceptions;

use Aedart\Contracts\ETags\Preconditions\Exceptions\InvalidRangeException;
use RuntimeException;

/**
 * Range Unit Not Supported Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Validators\Exceptions
 */
class RangeUnitNotSupported extends RuntimeException implements InvalidRangeException
{
}
