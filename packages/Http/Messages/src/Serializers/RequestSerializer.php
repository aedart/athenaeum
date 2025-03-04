<?php

namespace Aedart\Http\Messages\Serializers;

use Aedart\Contracts\Http\Messages\Serializers\RequestSerializer as RequestSerializerInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Request Serializer
 *
 * @see \Aedart\Contracts\Http\Messages\Serializers\RequestSerializer
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Serializers
 */
class RequestSerializer extends BaseSerializer implements RequestSerializerInterface
{
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $request = $this->getHttpRequest();

        return [
            'method' => $request->getMethod(),
            'target' => $request->getRequestTarget(),
            'uri' => (string) $request->getUri(),
            'protocol_version' => $request->getProtocolVersion(),
            'headers' => $request->getHeaders(),
            'body' => $this->messageContent($request)
        ];
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        $request = $this->getHttpRequest();

        $format = '%s %s HTTP/%s%s%s';
        $method = $request->getMethod();
        $target = $request->getRequestTarget();
        $protocol = $request->getProtocolVersion() . PHP_EOL;
        $headers = $this->serialiseHeaders($request->getHeaders()) . str_repeat(PHP_EOL, 2);
        $body = $this->messageContent($request);

        return sprintf(
            $format,
            $method,
            $target,
            $protocol,
            $headers,
            $body
        );
    }

    /**
     * @inheritDoc
     */
    public function setHttpRequest(RequestInterface|null $request): static
    {
        return $this->setHttpMessage($request);
    }

    /**
     * @inheritDoc
     */
    public function getHttpRequest(): RequestInterface|null
    {
        return $this->getHttpMessage();
    }

    /**
     * @inheritDoc
     */
    public function hasHttpRequest(): bool
    {
        return $this->hasHttpMessage();
    }

    /**
     * @inheritDoc
     */
    public function getDefaultHttpRequest(): RequestInterface|null
    {
        return $this->getDefaultHttpMessage();
    }
}
