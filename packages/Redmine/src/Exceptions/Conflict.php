<?php

namespace Aedart\Redmine\Exceptions;

/**
 * Conflict Exception
 *
 * Should be thrown when a 409 - Conflict response has been received from Redmine's API.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Exceptions
 */
class Conflict extends ErrorResponse
{
}
