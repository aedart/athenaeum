<?php

namespace Aedart\Contracts\Http\Clients\Requests\Builders\Expectations;

use Aedart\Contracts\Http\Clients\Responses\Status;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Expectation Not Fulfilled
 *
 * Contains details about why a response expectation was not met / fulfilled
 *
 * @see \Aedart\Contracts\Http\Clients\Exceptions\ExpectationNotMetException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Builders\Expectations
 */
interface ExpectationNotFulfilled
{
    /**
     * Returns the reason why expectation was not
     * fulfilled, in a human readable format
     *
     * @return string
     */
    public function reason(): string;

    /**
     * Returns the response Http Status
     *
     * @return Status
     */
    public function status(): Status;

    /**
     * The response that was received, but failed
     * to meet a response expectation
     *
     * @return ResponseInterface
     */
    public function response(): ResponseInterface;

    /**
     * The request that was sent
     *
     * @return RequestInterface
     */
    public function request(): RequestInterface;
}
