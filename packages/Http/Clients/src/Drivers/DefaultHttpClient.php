<?php

namespace Aedart\Http\Clients\Drivers;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Requests\Builders\GuzzleRequestBuilder;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Illuminate\Container\Container;

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
}
