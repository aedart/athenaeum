<?php

namespace Aedart\Http\Clients\Middleware;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Builders\HttpRequestBuilderAware;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Aedart\Contracts\Http\Messages\Type;
use Aedart\Http\Clients\Traits\HttpRequestBuilderTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Request Response Debugging Middleware
 *
 * WARNING: This middleware SHOULD NOT be used in a production environment!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Middleware
 */
class RequestResponseDebugging implements
    Middleware,
    HttpRequestBuilderAware
{
    use HttpRequestBuilderTrait;

    /**
     * {@inheritDoc}
     *
     * Dumps request / response, if request builder has requested it via
     * {@see Builder::debug} or {@see Builder::dd}.
     */
    public function process(RequestInterface $request, Handler $handler): ResponseInterface
    {
        // Obtain debugging callback
        $builder = $this->getHttpRequestBuilder();
        $callback = $builder->debugCallback();

        // Invoke debug for request...
        $callback(Type::REQUEST, $request, $builder);

        // Perform request and obtain response.
        $response = $handler->handle($request);

        // Invoke debug for response...
        $callback(Type::RESPONSE, $response, $builder);

        return $response;
    }
}
