<?php

namespace Aedart\Utils\Exceptions;

use Aedart\Contracts\Exceptions\UnsupportedOperationException;
use LogicException;

/**
 * Unsupported Operation Exception
 *
 * @see \Aedart\Contracts\Exceptions\UnsupportedOperationException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Exceptions
 */
class UnsupportedOperation extends LogicException implements UnsupportedOperationException
{
}
