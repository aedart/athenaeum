<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Handlers;

use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

/**
 * Capture Handler
 *
 * Captures a built request and options. Handler does NOT actually send the
 * request!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Handlers
 */
class CaptureHandler
{
    /**
     * The captured request
     *
     * @var RequestInterface|null
     */
    protected RequestInterface|null $request;

    /**
     * The processed options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * Returns the captured request
     *
     * @return RequestInterface|null
     */
    public function request(): RequestInterface|null
    {
        return $this->request;
    }

    /**
     * Returns the processed options
     *
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * Captures the built request and aborts the send process, by resolving to
     * an empty response.
     *
     * @param RequestInterface $request
     * @param array $options
     *
     * @return PromiseInterface
     */
    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        $this->request = $request;
        $this->options = $options;

        // Resolve with empty response
        return Create::promiseFor(new Response());
    }
}
