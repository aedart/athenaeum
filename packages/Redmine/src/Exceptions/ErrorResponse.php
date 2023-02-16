<?php

namespace Aedart\Redmine\Exceptions;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Http\Messages\Traits\HttpRequestTrait;
use Aedart\Http\Messages\Traits\HttpResponseTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Error Response Exception
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Exceptions
 */
class ErrorResponse extends RedmineException implements ErrorResponseException
{
    use HttpResponseTrait;
    use HttpRequestTrait;

    /**
     * ErrorResponse
     *
     * @param ResponseInterface $response Response from Redmine
     * @param RequestInterface $request The request that caused the error response
     * @param string $message [optional]
     * @param int $code [optional]
     * @param Throwable|null $previous [optional]
     */
    public function __construct(
        ResponseInterface $response,
        RequestInterface $request,
        string $message = "",
        int $code = 0,
        Throwable|null $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this
            ->setHttpRequest($request)
            ->setHttpResponse($response);
    }

    /**
     * @inheritDoc
     */
    public static function from(
        ResponseInterface $response,
        RequestInterface $request,
        string|null $message = null,
        Throwable|null $previous = null
    ): static {
        $message = $message ?? 'Received unexpected response from Redmine: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();

        return new static(
            $response,
            $request,
            $message,
            0,
            $previous
        );
    }
}
