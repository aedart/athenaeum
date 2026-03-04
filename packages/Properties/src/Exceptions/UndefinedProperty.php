<?php

namespace Aedart\Properties\Exceptions;

use Aedart\Contracts\Dto\Exceptions\UndefinedPropertyException;
use LogicException;

/**
 * Undefined Property Exception
 *
 * <br />
 *
 * Throw this exception when a non-existing property is attempted accessed
 *
 * @deprecated use {@see \Aedart\Dto\Exceptions\UndefinedProperty} instead, since v10.x
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Properties\Exceptions
 */
class UndefinedProperty extends LogicException implements UndefinedPropertyException
{
}
