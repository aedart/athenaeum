<?php

namespace Aedart\Http\Clients\Drivers;

use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Handler;
use Aedart\Contracts\Http\Clients\Requests\HasDriverOptions;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Handlers\SendRequestHandler;
use Aedart\Http\Clients\Requests\Builders\GuzzleRequestBuilder;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Illuminate\Container\Container;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Default Http Client
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Drivers
 */
class DefaultHttpClient extends BaseClient
{
    /**
     * The Guzzle Http Client
     *
     * @var GuzzleClient|null
     */
    protected ?GuzzleClient $client = null;

    /**
     * DefaultHttpClient constructor.
     *
     * @param Container $container
     * @param array $options [optional]
     */
    public function __construct(Container $container, array $options = [])
    {
        parent::__construct($container, $options);

        $this->client = new GuzzleClient();
    }

    /**
     * @inheritDoc
     */
    public function initialOptions(): array
    {
        return [
            // Builder specific options
            'data_format' => RequestOptions::FORM_PARAMS,

            // Guzzle specific options
            'http_errors' => false,
            'connect_timeout' => 5,
            'timeout' => 10,
            'allow_redirects' => [
                'max' => 1,
                'strict' => true,
                'referer' => true,
                'protocols' => ['http', 'https'],
                'track_redirects' => false
            ]
        ];
    }

    /**
     * {@inheritDoc}
     *
     * If given request contains driver specific options, via {@see HasDriverOptions}, then
     * these options are passed on to Guzzle.
     *
     * @see HasDriverOptions
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        // Extract driver specific options, if available
        $options = [];
        if ($request instanceof HasDriverOptions) {
            $options = $request->getDriverOptions();
        }

        // Prepare middleware handling and handle outgoing
        // request and incoming response
        return $this
            ->prepareMiddlewareHandler($options)
            ->handle($request);
    }

    /**
     * @inheritDoc
     *
     * @return GuzzleClient
     */
    public function driver()
    {
        return $this->client;
    }

    /**
     * @inheritDoc
     */
    public function makeBuilder(): Builder
    {
        return new GuzzleRequestBuilder($this, $this->getClientOptions());
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Prepares the middleware handler
     *
     * @param  array  $options Driver options
     *
     * @return Handler
     */
    protected function prepareMiddlewareHandler(array $options): Handler
    {
        return $this->makeMiddlewareHandler(
            $this->makeFallbackHandler($options),
            $this->middlewareFromOptions($options)
        );
    }

    /**
     * Make the fallback handler for when processing middleware.
     *
     * @param  array  $options  [optional] Request options
     *
     * @return Handler Responsible for sending request and returning received response
     */
    protected function makeFallbackHandler(array $options = []): Handler
    {
        return new SendRequestHandler($this->driver(), $options);
    }
}
