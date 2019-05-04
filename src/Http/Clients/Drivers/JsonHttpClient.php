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
}