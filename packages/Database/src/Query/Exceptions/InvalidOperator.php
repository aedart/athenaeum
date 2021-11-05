<?php

namespace Aedart\Database\Query\Exceptions;

use Aedart\Contracts\Database\Query\Exceptions\InvalidOperatorException;

/**
 * Invalid Operator
 *
 * @see \Aedart\Contracts\Database\Query\Exceptions\InvalidOperatorException
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Database\Query\Exceptions
 */
class InvalidOperator extends FilterException implements InvalidOperatorException
{
}
