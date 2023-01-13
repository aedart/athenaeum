<?php

namespace Aedart\Http\Api\Resources\Relations\Exceptions;

use Aedart\Contracts\Http\Api\Resources\Relations\Exceptions\RelationReferenceException as RelationReferenceExceptionInterface;
use RuntimeException;

/**
 * Relation Reference Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations\Exceptions
 */
class RelationReferenceException extends RuntimeException implements RelationReferenceExceptionInterface
{
}
