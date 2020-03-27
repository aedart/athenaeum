<?php

namespace Aedart\Http\Clients\Requests\Builders\Expectations;

use Aedart\Contracts\Http\Clients\Requests\Builders\Expectations\ExpectationNotFulfilled as ExpectationNotFulfilledInterface;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ExpectationNotFulfilled implements ExpectationNotFulfilledInterface
{
    /**
     * @inheritDoc
     */
    public function reason(): string
    {
        // TODO: Implement reason() method.
    }

    /**
     * @inheritDoc
     */
    public function status(): Status
    {
        // TODO: Implement status() method.
    }

    /**
     * @inheritDoc
     */
    public function response(): ResponseInterface
    {
        // TODO: Implement getResponse() method.
    }

    /**
     * @inheritDoc
     */
    public function request(): RequestInterface
    {
        // TODO: Implement getRequest() method.
    }
}
