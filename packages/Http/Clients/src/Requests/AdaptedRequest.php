<?php

namespace Aedart\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\HasDriverOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Adapted Request
 *
 * Contains driver specific options that allows a {@see Client}'s native
 * driver to send this given requests.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests
 */
class AdaptedRequest implements
    RequestInterface,
    HasDriverOptions
{
    /**
     * The actual request
     *
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * Driver specific options
     *
     * @var array
     */
    protected array $driverOptions = [];

    /**
     * AdaptedRequest constructor.
     *
     * @param RequestInterface $request
     * @param array $driverOptions [optional]
     */
    public function __construct(RequestInterface $request, array $driverOptions = [])
    {
        $this->request = $request;
        $this->driverOptions = $driverOptions;
    }

    /**
     * @inheritDoc
     */
    public function getDriverOptions(): array
    {
        return $this->driverOptions;
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        return $this->request->getProtocolVersion();
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        return new static(
            $this->request->withProtocolVersion($version),
            $this->getDriverOptions()
        );
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->request->getHeaders();
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        return $this->request->hasHeader($name);
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        return $this->request->getHeader($name);
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        return $this->request->getHeaderLine($name);
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        return new static(
            $this->request->withHeader($name, $value),
            $this->getDriverOptions(),
        );
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        return new static(
            $this->request->withAddedHeader($name, $value),
            $this->getDriverOptions(),
        );
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        return new static(
            $this->request->withoutHeader($name),
            $this->getDriverOptions(),
        );
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->request->getBody();
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        return new static(
            $this->request->withBody($body),
            $this->getDriverOptions(),
        );
    }

    /**
     * @inheritDoc
     */
    public function getRequestTarget()
    {
        return $this->request->getRequestTarget();
    }

    /**
     * @inheritDoc
     */
    public function withRequestTarget($requestTarget)
    {
        return new static(
            $this->request->withRequestTarget($requestTarget),
            $this->getDriverOptions(),
        );
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return $this->request->getMethod();
    }

    /**
     * @inheritDoc
     */
    public function withMethod($method)
    {
        return new static(
            $this->request->withMethod($method),
            $this->getDriverOptions(),
        );
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        return $this->request->getUri();
    }

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        return new static(
            $this->request->withUri($uri, $preserveHost),
            $this->getDriverOptions(),
        );
    }
}
