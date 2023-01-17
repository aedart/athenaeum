<?php

namespace Aedart\Contracts\Redmine\Exceptions;

use Aedart\Contracts\Http\Messages\HttpRequestAware;
use Aedart\Contracts\Http\Messages\HttpResponseAware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Error Response Exception
 *
 * Should be thrown whenever an error response has been received, e.g.
 * Http Status 4xx or 5xx.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Redmine\Exceptions
 */
interface ErrorResponseException extends RedmineException,
    HttpResponseAware,
    HttpRequestAware
{
    /**
     * Create a new error response exception from given response
     *
     * @param ResponseInterface $response Received response from the Redmine Api
     * @param RequestInterface $request The request that caused the error response
     * @param string|null $message [optional] Evt. custom error message
     * @param Throwable|null $previous [optional] Evt. previous exception
     *
     * @return static
     */
    public static function from(
        ResponseInterface $response,
        RequestInterface $request,
        string|null $message = null,
        Throwable|null $previous = null
    ): static;
}
