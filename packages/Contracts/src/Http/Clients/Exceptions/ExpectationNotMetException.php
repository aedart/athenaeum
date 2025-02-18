<?php

namespace Aedart\Contracts\Http\Clients\Exceptions;

use Aedart\Contracts\Http\Clients\Requests\Builders\Expectations\ExpectationNotFulfilled;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Response Expectation Not Met Exception
 *
 * Should be thrown when a response didn't meet an expectation, e.g. when you
 * expected a response's http status code to mach 200 (Ok), but 400 was received.
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Builder::expect()
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Exceptions
 */
interface ExpectationNotMetException extends Throwable
{
    /**
     * Returns details about why expectation was not met
     *
     * @return ExpectationNotFulfilled
     */
    public function getExpectation(): ExpectationNotFulfilled;

    /**
     * Returns the reason why expectation was not
     * fulfilled, in a human-readable format
     *
     * @return string
     */
    public function getReason(): string;

    /**
     * Returns the response Http Status
     *
     * @return Status
     */
    public function getStatus(): Status;

    /**
     * The response that was received, but failed
     * to meet a response expectation
     *
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;

    /**
     * The request that was sent
     *
     * @return RequestInterface|null
     */
    public function getRequest(): RequestInterface|null;
}
