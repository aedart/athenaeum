<?php

namespace Aedart\Http\Clients\Middleware;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builders\HttpRequestBuilderAware;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Aedart\Contracts\Http\Messages\Type;
use Aedart\Http\Clients\Traits\HttpRequestBuilderTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Request Response Logging Middleware
 *
 * @see RequestResponseDebugging
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Middleware
 */
class RequestResponseLogging implements
    Middleware,
    HttpRequestBuilderAware
{
    use HttpRequestBuilderTrait;

    /**
     * {@inheritDoc}
     *
     * Logs request / response, if request builder has requested it via
     * {@see Builder::log}
     */
    public function process(RequestInterface $request, Handler $handler): ResponseInterface
    {
        // Obtain logging callback
        $builder = $this->getHttpRequestBuilder();
        $callback = $builder->logCallback();

        // Invoke log for request...
        $callback(Type::REQUEST, $request, $builder);

        // Perform request and obtain response.
        $response = $handler->handle($request);

        // Invoke log for response...
        $callback(Type::RESPONSE, $response, $builder);

        return $response;
    }
}
