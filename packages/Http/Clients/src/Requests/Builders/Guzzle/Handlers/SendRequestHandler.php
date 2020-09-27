<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Handlers;

use Aedart\Contracts\Http\Clients\Requests\Handler;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Guzzle "Send Request" Handler
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Handler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Handlers
 */
class SendRequestHandler implements Handler
{
    /**
     * Guzzle client
     *
     * @var GuzzleClient
     */
    protected GuzzleClient $driver;

    /**
     * Request options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * SendRequestHandler constructor.
     *
     * @param  GuzzleClient  $driver
     * @param  array  $options  [optional]
     */
    public function __construct(GuzzleClient $driver, array $options = [])
    {
        $this->driver = $driver;
        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        return $this->driver->send($request, $this->options);
    }
}
