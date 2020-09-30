<?php

namespace Aedart\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Middleware;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder as Query;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Traits\ForwardsCalls;
use Psr\Http\Message\ResponseInterface;

/**
 * Http Request Base Builder
 *
 * Abstraction for Http Request Builders.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders
 */
abstract class BaseBuilder implements
    Builder,
    ContainerAware
{
    use HttpClientTrait;
    use ContainerTrait;
    use Concerns\Attachments;
    use Concerns\BaseUrl;
    use Concerns\Conditions;
    use Concerns\Cookies;
    use Concerns\DataFormat;
    use Concerns\DriverOptions;
    use Concerns\HttpBody;
    use Concerns\HttpHeaders;
    use Concerns\HttpMethod;
    use Concerns\HttpProtocolVersion;
    use Concerns\HttpQuery;
    use Concerns\RequestCriteria;
    use Concerns\HttpUri;
    use Concerns\ResponseExpectations;
    use Concerns\Middleware;
    use Concerns\Debugging;
    use ForwardsCalls;

    /**
     * BaseBuilder constructor.
     *
     * @param Client $client
     * @param array $options [optional] Driver specific options
     */
    public function __construct(Client $client, array $options = [])
    {
        $this
            ->setHttpClient($client)
            ->setContainer($client->getContainer());

        // Create new middleware collection
        $this->middleware = $this->makeMiddlewareCollation();

        // Prepare this builder, using the following options
        $this->options = $this->prepareBuilderFromOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function get($uri = null): ResponseInterface
    {
        return $this->request('GET', $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function head($uri = null): ResponseInterface
    {
        return $this->request('HEAD', $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('POST', $uri, [
            RequestOptions::FORM_PARAMS => $body
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('PUT', $uri, [
            RequestOptions::FORM_PARAMS => $body
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('DELETE', $uri, [
            RequestOptions::FORM_PARAMS => $body
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function options($uri = null): ResponseInterface
    {
        return $this->request('OPTIONS', $uri);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uri = null, array $body = []): ResponseInterface
    {
        return $this->request('PATCH', $uri, [
            RequestOptions::FORM_PARAMS => $body
        ]);
    }

    /**
     * @inheritdoc
     */
    public function client(): Client
    {
        return $this->getHttpClient();
    }

    /**
     * @inheritDoc
     *
     * @return mixed
     */
    public function driver()
    {
        return $this->client()->driver();
    }

    /**
     * Forwards dynamic calls to the Http Query Builder
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // Forward calls to the Http Query Builder, but return this
        // request builder instance, so that request building can
        // be continued. Only if anything other than a query is returned,
        // then the result is returned instead.
        $result = $this->forwardCallTo($this->query(), $method, $parameters);
        if ($result instanceof Query) {
            return $this;
        }

        return $result;
    }
}
