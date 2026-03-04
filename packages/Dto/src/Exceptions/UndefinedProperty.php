<?php

namespace Aedart\Dto\Exceptions;

use Aedart\Contracts\Dto\Exceptions\UndefinedPropertyException;
use LogicException;

/**
 * Undefined Property Exception
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Dto\Exceptions
 */
class UndefinedProperty extends LogicException implements UndefinedPropertyException
{
}
