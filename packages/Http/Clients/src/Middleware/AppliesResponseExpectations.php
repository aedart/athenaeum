<?php

namespace Aedart\Http\Clients\Middleware;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builders\HttpRequestBuilderAware;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Aedart\Http\Clients\Traits\HttpRequestBuilderTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Applies Response Expectations Middleware
 *
 * Applies assigned response expectations to the incoming response.
 *
 * @see \Aedart\Contracts\Http\Clients\Client::getExpectations
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Middleware
 */
class AppliesResponseExpectations implements
    Middleware,
    HttpRequestBuilderAware
{
    use HttpRequestBuilderTrait;

    /**
     * {@inheritDoc}
     *
     * @throws Throwable If response did not meet an expectation
     */
    public function process(RequestInterface $request, Handler $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        // Obtain assigned response expectations from client
        $expectations = $this->getHttpRequestBuilder()->getExpectations();
        foreach ($expectations as $expectation) {
            $expectation->apply($request, $response);
        }

        return $response;
    }
}
