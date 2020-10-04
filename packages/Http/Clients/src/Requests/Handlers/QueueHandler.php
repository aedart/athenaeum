<?php

namespace Aedart\Http\Clients\Requests\Handlers;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Queue Handler
 *
 * Heavily inspired by PSR-15's example of a "Queue-based" request handler.
 * @see https://www.php-fig.org/psr/psr-15/meta/
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Handlers
 */
class QueueHandler implements Handler
{
    /**
     * The fallback handler
     *
     * @var Handler
     */
    protected Handler $fallbackHandler;

    /**
     * Middleware to process
     *
     * @var Middleware[]
     */
    protected array $middleware = [];

    /**
     * QueueHandler constructor.
     *
     * @param  Handler  $fallbackHandler
     */
    public function __construct(Handler $fallbackHandler)
    {
        $this->fallbackHandler = $fallbackHandler;
    }

    /**
     * @inheritDoc
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        if (0 === count($this->middleware)) {
            return $this->getFallbackHandler()->handle($request);
        }

        $next = array_shift($this->middleware);
        return $next->process($request, $this);
    }

    /**
     * Add middleware to process outgoing request and
     * incoming response
     *
     * @param  Middleware  $middleware
     *
     * @return self
     */
    public function add(Middleware $middleware)
    {
        $this->middleware[] = $middleware;

        return $this;
    }

    /**
     * Add a list of middleware to process the outgoing
     * request and incoming response
     *
     * @param  Middleware[]  $list
     *
     * @return self
     */
    public function addMultiple(array $list)
    {
        foreach ($list as $middleware) {
            $this->add($middleware);
        }

        return $this;
    }

    /**
     * Get the fallback handler
     *
     * @return Handler
     */
    public function getFallbackHandler(): Handler
    {
        return $this->fallbackHandler;
    }
}
