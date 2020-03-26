<?php

namespace Aedart\Contracts\Http\Clients\Responses;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidStatusCodeException;
use Psr\Http\Message\ResponseInterface;

/**
 * Response Http Status
 *
 * Contains Http status code and phrase of a response
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Responses
 */
interface Status
{
    /**
     * Returns the Http response status code
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @return int
     */
    public function code(): int;

    /**
     * Returns the Http response status reason phrase
     *
     * @return string Empty if no reason phrase available
     */
    public function phrase(): string;

    /**
     * Determine if status code is "Informational" (1xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Information_responses
     *
     * @return bool
     */
    public function isInformational(): bool;

    /**
     * Determine is status code is "Successful" (2xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Successful_responses
     *
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * Determine if status code is "Redirection" (3xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Redirection_messages
     *
     * @return bool
     */
    public function isRedirection(): bool;

    /**
     * Determine if status code is "Client Error" (4xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Client_error_responses
     *
     * @return bool
     */
    public function isClientError(): bool;

    /**
     * Determine if status code is "Server Error" (5xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Server_error_responses
     *
     * @return bool
     */
    public function isServerError(): bool;

    /**
     * Creates a new Http response status code instance from
     * the given request
     *
     * @param ResponseInterface $response
     *
     * @return static
     *
     * @throws InvalidStatusCodeException
     */
    public static function fromResponse(ResponseInterface $response): Status;
}
