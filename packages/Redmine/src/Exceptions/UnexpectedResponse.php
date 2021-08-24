<?php

namespace Aedart\Redmine\Exceptions;

/**
 * Unexpected Response Exception
 *
 * Should be thrown whenever an unexpected API response was received from Redmine.
 * E.g. when you expected Http Status 2xx or 4xx, but a code 5xx is received.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Exceptions
 */
class UnexpectedResponse extends ErrorResponse
{
}