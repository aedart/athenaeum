<?php

namespace Aedart\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Builders\Guzzle\CookieJarAware;
use Aedart\Http\Clients\Requests\AdaptedRequest;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Handlers\CaptureHandler;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\AppliesBaseUrl;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\AppliesCookies;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\AppliesHeaders;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\AppliesHttpProtocolVersion;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\AppliesPayload;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\AppliesQuery;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\ExtractsBaseUrl;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\ExtractsCookies;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\ExtractsHeaders;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\ExtractsHttpProtocolVersion;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\ExtractsPayload;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes\ExtractsQuery;
use Aedart\Http\Clients\Requests\Builders\Guzzle\Traits\CookieJarTrait;
use Aedart\Http\Clients\Requests\Builders\Pipes\MergeWithBuilderOptions;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Guzzle Http Request Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders
 */
class GuzzleRequestBuilder extends BaseBuilder implements CookieJarAware
{
    use CookieJarTrait {
        setCookieJar as traitSetCookieJar;
    }

    /**
     * The data format to use
     *
     * @var string
     */
    protected string $dataFormat = RequestOptions::FORM_PARAMS;

    /**
     * Pipes that are used to prepare this builder,
     * based on provided driver options
     *
     * @var string[] List of class paths
     */
    protected array $prepareBuilderPipes = [
        ExtractsBaseUrl::class,
        ExtractsHeaders::class,
        ExtractsHttpProtocolVersion::class,
        ExtractsQuery::class,
        ExtractsCookies::class,
        ExtractsPayload::class
    ];

    /**
     * Pipes that prepare the driver options, before
     * applied on request and sent
     *
     * @var string[] List of class paths
     */
    protected array $beforeRequestPipes = [
        MergeWithBuilderOptions::class,
        AppliesBaseUrl::class,
        AppliesHeaders::class,
        AppliesHttpProtocolVersion::class,
        AppliesQuery::class,
        AppliesCookies::class,
        AppliesPayload::class,
    ];

    /**
     * Temporary request options
     *
     * @var array
     */
    protected array $nextRequestOptions = [];

    /**
     * GuzzleRequestBuilder constructor.
     *
     * @param Client $client
     * @param array $options [optional] Guzzle Request Options
     */
    public function __construct(Client $client, array $options = [])
    {
        parent::__construct($client, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function request(string $method = null, $uri = null, array $options = []): ResponseInterface
    {
        $method = $method ?? $this->getMethod();
        $uri = $uri ?? $this->getUri();

        // Set the next response's options
        // NOTE: This is automatically reset via "createRequest".
        $this->nextRequestOptions = $options;

        // Send the request
        return $this->client()->sendRequest(
            $this->createRequest($method, $uri)
        );
    }

    /**
     * @inheritDoc
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        // Prepare the driver options
        $options = $this->processDriverOptions(
            $this->beforeRequestPipes,
            $this->nextRequestOptions
        );

        // Reset the next request options, to avoid memory leaks or
        // other unwanted behaviour
        $this->nextRequestOptions = [];

        // Obtain original handler
        $originalHandler = $options['handler'] ?? null;

        // Create a "capture" handler
        $captured = new CaptureHandler();
        $options['handler'] = $captured;

        // Perform a request, which is NOT sent, but rather captured,
        // once it has been built. This should NOT yield any useful
        // response, nor side-effects.
        $this->driver()->request($method, $uri, $options);

        // Overwrite the next request options, with the processed options
        // from Guzzle. This should limit processing time if the builder's
        // "request()" is sending the captured request.
        $options = $captured->options();

        // Restore original handler option.
        unset($options['handler']);
        if (isset($originalHandler)) {
            $options['handler'] = $originalHandler;
        }

        // Finally, adapt the captured request and add the driver
        // specific options, so that the client is able to pass them
        // on to Guzzle.
        return new AdaptedRequest(
            $captured->request(),
            $options
        );
    }

    /**
     * @inheritDoc
     */
    public function formFormat(): Builder
    {
        return $this
            ->useDataFormat('form_params')
            ->withContentType('application/x-www-form-urlencoded');
    }

    /**
     * @inheritDoc
     */
    public function jsonFormat(): Builder
    {
        return $this
            ->useDataFormat('json')
            ->withAccept($this->jsonAccept)
            ->withContentType($this->jsonContentType);
    }

    /**
     * @inheritDoc
     */
    public function multipartFormat(): Builder
    {
        return $this
            ->useDataFormat('multipart')
            ->withContentType('multipart/form-data');
    }

    /**
     * @inheritDoc
     */
    public function useBasicAuth(string $username, string $password): Builder
    {
        return $this->withOption('auth', [ $username, $password ]);
    }

    /**
     * @inheritDoc
     */
    public function useDigestAuth(string $username, string $password): Builder
    {
        return $this->withOption('auth', [ $username, $password, 'digest' ]);
    }

    /**
     * @inheritdoc
     */
    public function withRawPayload($body): Builder
    {
        $this->useDataFormat(RequestOptions::BODY);

        return parent::withRawPayload($body);
    }

    /**
     * @inheritDoc
     */
    public function maxRedirects(int $amount): Builder
    {
        if ($amount === 0) {
            return $this->disableRedirects();
        }

        $allowRedirects = $this->getOption('allow_redirects') ?? [];

        $modified = array_merge($allowRedirects, [
            'max' => $amount
        ]);

        return $this->withOption('allow_redirects', $modified);
    }

    /**
     * @inheritDoc
     */
    public function disableRedirects(): Builder
    {
        return $this->withOption('allow_redirects', false);
    }

    /**
     * @inheritDoc
     */
    public function withTimeout(float $seconds): Builder
    {
        return $this->withOption('timeout', $seconds);
    }

    /**
     * @inheritDoc
     */
    public function getTimeout(): float
    {
        return (float) $this->getOption('timeout');
    }

    /**
     * @inheritDoc
     *
     * @return GuzzleClient
     */
    public function driver()
    {
        return parent::driver();
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function setCookieJar(?CookieJarInterface $jar)
    {
        // Ensure that we overwrite the "cookies" option for
        // Guzzle with the new cookie jar instance. Otherwise
        // this might not have any effect.
        return $this
            ->withOption('cookies', $jar)
            ->traitSetCookieJar($jar);
    }

    /**
     * @inheritdoc
     */
    public function getDefaultCookieJar(): ?CookieJarInterface
    {
        return new CookieJar(true);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function prepareBuilderFromOptions(array $options = []): array
    {
        $options = parent::prepareBuilderFromOptions($options);

        return $this->processDriverOptions($this->prepareBuilderPipes, $options);
    }
}
