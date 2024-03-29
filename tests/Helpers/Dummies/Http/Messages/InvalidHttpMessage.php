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
    public function getProtocolVersion()
    {
        return '0.x';
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        return new static();
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return FileStream::openMemory();
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        return new static();
    }
}
