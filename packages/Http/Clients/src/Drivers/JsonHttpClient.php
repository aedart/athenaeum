<?php

namespace Aedart\Http\Clients\Drivers;

use Psr\Http\Message\ResponseInterface;

/**
 * Json Http Client
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Drivers
 */
class JsonHttpClient extends DefaultHttpClient
{
    /**
     * Default Accept header value
     *
     * @var string
     */
    protected string $defaultAcceptHeader = 'application/json';

    /**
     * Default Content-Type header value
     *
     * @var string
     */
    protected string $defaultContentTypeHeader = 'application/json';

    /**
     * @inheritdoc
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->setInitialHeadersIfRequired();
    }

    /**
     * {@inheritdoc}
     */
    public function get($uri): ResponseInterface
    {
        return $this->request('GET', $uri, [ 'json' => [] ]);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, array $body = []): ResponseInterface
    {
        return $this->request('POST', $uri, [ 'json' => $body ]);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri, array $body = []): ResponseInterface
    {
        return $this->request('PUT', $uri, [ 'json' => $body ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri, array $body = []): ResponseInterface
    {
        return $this->request('DELETE', $uri, [ 'json' => $body ]);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uri, array $body = []): ResponseInterface
    {
        return $this->request('PATCH', $uri, [ 'json' => $body ]);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Sets the Accept and Content-Type headers for next request,
     * if not already specified.
     *
     * @return self
     */
    protected function setInitialHeadersIfRequired()
    {
        $headers = [];

        if (!$this->hasInitialHeader('Accept')) {
            $headers['Accept'] = $this->defaultAcceptHeader;
        }

        if (!$this->hasInitialHeader('Content-Type')) {
            $headers['Content-Type'] = $this->defaultContentTypeHeader;
        }

        // Merge into the initial options
        $this->initialOptions['headers'] = $this->initialOptions['headers'] ?? [];
        $this->initialOptions['headers'] = array_merge_recursive($this->initialOptions['headers'], $headers);

        // Ensure that next request has these initial headers set.
        $this->resetOptionsForNextRequest();

        return $this;
    }
}
