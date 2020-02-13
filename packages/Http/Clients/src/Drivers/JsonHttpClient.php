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

        $this->setHeadersIfRequired();
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
    protected function setHeadersIfRequired()
    {
        $accept = $this->getHeader('Accept');
        if( ! isset($accept)){
            $this->withHeader('Accept', $this->defaultAcceptHeader);
        }

        $contentType = $this->getHeader('Content-Type');
        if( ! isset($contentType)){
            $this->withHeader('Content-Type', $this->defaultContentTypeHeader);
        }

        return $this;
    }
}
