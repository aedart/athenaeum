<?php

namespace Aedart\Redmine\Exceptions;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Not Found Exception
 *
 * Should be thrown when a resource was expected, but does not exist
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Exceptions
 */
class NotFound extends ErrorResponse
{
}