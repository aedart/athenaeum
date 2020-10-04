<?php

namespace Aedart\Http\Clients\Middleware;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Builders\HttpRequestBuilderAware;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Aedart\Contracts\Http\Messages\Serializers\Factory;
use Aedart\Http\Clients\Traits\HttpRequestBuilderTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Request Response Debugging
 *
 * Middleware requires a Http Message Serializer {@see Factory} to be
 * available via Service Container (or set manually).
 *
 * Also, Symfony's {@see VarDumper} MUST be available, for this
 * middleware to work as intended.
 *
 * WARNING: This middleware SHOULD NOT be used in a production environment!
 *
 * @see \Aedart\Contracts\Http\Messages\Serializers\Factory
 * @see \Symfony\Component\VarDumper\VarDumper
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
     * Request type Http Message
     */
    public const TYPE_REQUEST = 'request';

    /**
     * Response type Http Message
     */
    public const TYPE_RESPONSE = 'response';

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
        $callback(static::TYPE_REQUEST, $request, $builder);

        // Perform request and obtain response.
        $response = $handler->handle($request);

        // Invoke debug for response...
        $callback(static::TYPE_RESPONSE, $response, $builder);

        return $response;
    }
}
