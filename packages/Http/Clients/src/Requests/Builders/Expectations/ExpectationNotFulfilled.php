<?php

namespace Aedart\Http\Clients\Requests\Builders\Expectations;

use Aedart\Contracts\Http\Clients\Requests\Builders\Expectations\ExpectationNotFulfilled as ExpectationNotFulfilledInterface;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Expectation Not Fulfilled
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Builders\Expectations\ExpectationNotFulfilled
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Expectations
 */
class ExpectationNotFulfilled implements ExpectationNotFulfilledInterface
{
    /**
     * Reason why expectation was not met
     *
     * @var string
     */
    protected string $reason;

    /**
     * Response's Http status code
     *
     * @var Status
     */
    protected Status $status;

    /**
     * The received response
     *
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * The request that was sent
     *
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * ExpectationNotFulfilled constructor.
     *
     * @param string $reason Reason why expectation was not met
     * @param Status $status Response's Http status code
     * @param ResponseInterface $response Response that was received
     * @param RequestInterface $request Request that was sent which lead to given response
     */
    public function __construct(
        string $reason,
        Status $status,
        ResponseInterface $response,
        RequestInterface $request
    ) {
        $this->reason = $reason;
        $this->status = $status;
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function reason(): string
    {
        return $this->reason;
    }

    /**
     * @inheritDoc
     */
    public function status(): Status
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function response(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @inheritDoc
     */
    public function request(): RequestInterface
    {
        return $this->request;
    }
}
