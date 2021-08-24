<?php

namespace Aedart\Contracts\Redmine\Exceptions;

use Aedart\Contracts\Http\Messages\HttpResponseAware;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Error Response Exception
 *
 * Should be thrown whenever an error response has been received, e.g.
 * Http Status 4xx or 5xx.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Redmine\Exceptions
 */
interface ErrorResponseException extends RedmineException,
    HttpResponseAware
{
    /**
     * Create a new error response exception from given response
     *
     * @param ResponseInterface $response Received response from the Redmine Api
     * @param string|null $message [optional] Evt. custom error message
     * @param Throwable|null $previous [optional] Evt. previous exception
     *
     * @return ErrorResponseException
     */
    static public function fromResponse(ResponseInterface $response, ?string $message = null, ?Throwable $previous = null): ErrorResponseException;
}