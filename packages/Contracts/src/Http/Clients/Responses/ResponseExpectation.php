<?php

namespace Aedart\Contracts\Http\Clients\Responses;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Response Expectation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Responses
 */
interface ResponseExpectation
{
    /**
     * Add an expectation for the next response.
     *
     * An "expectation" is a callback that verifies the received response's Http status code,
     * Http headers, and possibly it's payload body. If the response is considered invalid,
     * the callback SHOULD throw an exception.
     *
     * @param callable(Status $status, ResponseInterface $response, RequestInterface $request): (void) $expectation Expectation callback.
     *
     * @return self
     */
    public function expect(callable $expectation): static;

    /**
     * Returns the assigned expectation callback
     *
     * @return callable(Status $status, ResponseInterface $response, RequestInterface $request): (void)
     */
    public function getExpectation(): callable;

    /**
     * The response expectation
     *
     * @param  Status  $status
     * @param  ResponseInterface  $response
     * @param  RequestInterface  $request
     *
     * @return void
     *
     * @throws Throwable If response did not meet the expectation
     */
    public function expectation(
        Status $status,
        ResponseInterface $response,
        RequestInterface $request
    ): void;

    /**
     * Apply the response expectation callback for given response
     *
     * @param  RequestInterface  $request The performed request that triggered response
     * @param  ResponseInterface  $response The received response
     *
     * @return void
     *
     * @throws Throwable If response did not meet the expectation
     */
    public function apply(RequestInterface $request, ResponseInterface $response): void;
}
