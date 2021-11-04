<?php

namespace Aedart\Contracts\Database\Query\Exceptions;

/**
 * Invalid Operator Exception
 *
 * Should be thrown whenever an invalid or unsupported operator is attempted
 * used by a criteria / field criteria.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Database\Query\Exceptions
 */
interface InvalidOperatorException extends CriteriaException
{
}
