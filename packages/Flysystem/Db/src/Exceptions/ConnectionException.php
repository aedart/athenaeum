<?php

namespace Aedart\Flysystem\Db\Exceptions;

/**
 * Connection Exception
 *
 * Should be thrown when unable to connect to database or other connection
 * related issues arise.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Exceptions
 */
class ConnectionException extends DatabaseAdapterException
{
}