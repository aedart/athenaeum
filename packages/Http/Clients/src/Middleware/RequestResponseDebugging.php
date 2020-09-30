<?php

namespace Aedart\Http\Clients\Middleware;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Builders\HttpRequestBuilderAware;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Aedart\Contracts\Http\Messages\Exceptions\SerializationException;
use Aedart\Contracts\Http\Messages\Serializers\Factory;
use Aedart\Http\Clients\Traits\HttpRequestBuilderTrait;
use Aedart\Http\Messages\Traits\HttpSerializerFactoryTrait;
use Psr\Http\Message\MessageInterface;
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
    use HttpSerializerFactoryTrait;

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
     *
     * @throws SerializationException If Request / Response could not be serialized
     */
    public function process(RequestInterface $request, Handler $handler): ResponseInterface
    {
        // Debug request...
        $this->dumpIfNeeded(static::TYPE_REQUEST, $request);

        $response = $handler->handle($request);

        // Debug response...
        $this->dumpIfNeeded(static::TYPE_RESPONSE, $response);

        return $response;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Dumps given Http Message, if required
     *
     * @param  string  $type
     * @param  MessageInterface  $message
     *
     * @throws SerializationException
     */
    protected function dumpIfNeeded(string $type, MessageInterface $message)
    {
        $builder = $this->getHttpRequestBuilder();

        if ($builder->mustDumpAndDie()) {
            // Obtain reference to var dumper handler.
            $originalHandler = VarDumper::setHandler(null);
            VarDumper::setHandler($originalHandler);

            // Dump...
            VarDumper::dump($this->makeContext($type, $message));

            // Exist script, if original handler is null. Otherwise
            // we have to assume that something else is going on, e.g.
            // a running test or other special kind of debugging.
            if (null === $originalHandler) {
                exit(1);
            }
        }

        if ($builder->mustDebug()) {
            VarDumper::dump($this->makeContext($type, $message));
        }
    }

    /**
     * Creates a context array for given Http Message
     *
     * @param string $type E.g. request or response
     * @param  MessageInterface  $message
     * @return array
     *
     * @throws SerializationException
     */
    protected function makeContext(string $type, MessageInterface $message): array
    {
        $serialized = $this
            ->getHttpSerializerFactory()
            ->make($message)
            ->toArray();

        return [ $type => $serialized ];
    }
}
