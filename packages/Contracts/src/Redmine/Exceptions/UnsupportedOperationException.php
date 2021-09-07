<?php

namespace Aedart\Contracts\Redmine\Exceptions;

/**
 * Unsupported Operation Exception
 *
 * Should be thrown whenever an operation (request) is attempted to Redmine's API,
 * yet is not supported by the API.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Redmine\Exceptions
 */
interface UnsupportedOperationException extends RedmineException
{
}
