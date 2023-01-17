<?php

namespace Aedart\Contracts\Redmine\Exceptions;

/**
 * Unsupported Operation Exception
 *
 * Should be thrown whenever an operation (request) is attempted to Redmine's API,
 * yet is not supported by the API.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Redmine\Exceptions
 */
interface UnsupportedOperationException extends RedmineException
{
}
