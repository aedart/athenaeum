<?php

namespace Aedart\Redmine\Exceptions;

use Aedart\Contracts\Redmine\Exceptions\ErrorResponseException;
use Aedart\Http\Messages\Traits\HttpResponseTrait;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Error Response Exception
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Exceptions
 */
class ErrorResponse extends RedmineException implements ErrorResponseException
{
    use HttpResponseTrait;

    /**
     * @inheritDoc
     */
    public function __construct(ResponseInterface $response, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->setHttpResponse($response);
    }

    /**
     * @inheritDoc
     */
    static public function fromResponse(
        ResponseInterface $response,
        ?string $message = null,
        ?Throwable $previous = null
    ): ErrorResponseException {
        $message = $message ?? 'Received unexpected response from Redmine: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();

        return new static($response, $message, 0, $previous);
    }
}