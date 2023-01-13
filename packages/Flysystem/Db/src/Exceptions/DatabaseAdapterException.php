<?php

namespace Aedart\Flysystem\Db\Exceptions;

use Aedart\Contracts\Flysystem\Db\Exceptions\DatabaseAdapterException as DatabaseAdapterExceptionInterface;
use RuntimeException;

/**
 * Database Adapter Exception
 *
 * General exception for when database adapters.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Exceptions
 */
class DatabaseAdapterException extends RuntimeException implements DatabaseAdapterExceptionInterface
{
}
