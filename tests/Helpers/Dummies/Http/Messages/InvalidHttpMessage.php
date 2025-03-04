<?php


namespace Aedart\Tests\Helpers\Dummies\Http\Messages;

use Aedart\Streams\FileStream;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Invalid Http Message
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Messages
 */
class InvalidHttpMessage implements MessageInterface
{
    /**
     * @inheritDoc
     */
    public function getProtocolVersion(): string
    {
        return '0.x';
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion(string $version): MessageInterface
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function hasHeader(string $name): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getHeader(string $name): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine(string $name): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function withHeader(string $name, $value): MessageInterface
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader(string $name, $value): MessageInterface
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader(string $name): MessageInterface
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function getBody(): StreamInterface
    {
        return FileStream::openMemory();
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body): MessageInterface
    {
        return new static();
    }
}
