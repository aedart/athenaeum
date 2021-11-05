<?php

namespace Aedart\Database\Query\Exceptions;

use Aedart\Contracts\Database\Query\Exceptions\CriteriaException;
use RuntimeException;

/**
 * Filter Exception (Criteria Exception)
 *
 * @see \Aedart\Contracts\Database\Query\Exceptions\CriteriaException
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Database\Query\Exceptions
 */
class FilterException extends RuntimeException implements CriteriaException
{
}
