<?php

namespace Aedart\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\Meta;
use Aedart\Contracts\Streams\Stream as StreamInterface;
use Psr\Http\Message\StreamInterface as PsrStreamInterface;

/**
 * Stream
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams
 */
class Stream implements StreamInterface
{
    /**
     * @inheritDoc
     */
    public static function make($stream, array|Meta|null $meta = null): static
    {
        // TODO: Implement make() method.
    }

    /**
     * @inheritDoc
     */
    public static function makeFrom(PsrStreamInterface $stream, array|Meta|null $meta = null): static
    {
        // TODO: Implement makeFrom() method.
    }

    /**
     * @inheritDoc
     */
    public static function open(
        string $filename,
        string $mode,
        bool $useIncludePath = false,
        $context = null
    ): static
    {
        // TODO: Implement open() method.
    }

    /**
     * @inheritDoc
     */
    public static function openMemory(string $mode = 'w+b', $context = null): static
    {
        return static::open('php://memory', $mode, false, $context);
    }

    /**
     * @inheritDoc
     */
    public static function openTemporary(string $mode = 'w+b', int|null $maxMemory = null, $context = null): static
    {
        $filename = 'php://temp';
        if (isset($maxMemory)) {
            $filename = $filename . "/maxmemory:{$maxMemory}";
        }

        return static::open($filename, $mode, false, $context);
    }


    /**
     * @inheritDoc
     */
    public function close()
    {
        // TODO: Implement close() method.
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        // TODO: Implement detach() method.
    }

    /**
     * @inheritDoc
     */
    public function getSize(): int|null
    {
        // TODO: Implement getSize() method.
    }

    /**
     * @inheritDoc
     */
    public function tell(): int
    {
        // TODO: Implement tell() method.
    }

    /**
     * @inheritDoc
     */
    public function eof(): bool
    {
        // TODO: Implement eof() method.
    }

    /**
     * @inheritDoc
     */
    public function isSeekable(): bool
    {
        // TODO: Implement isSeekable() method.
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        // TODO: Implement seek() method.
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    /**
     * @inheritDoc
     */
    public function isWritable(): bool
    {
        // TODO: Implement isWritable() method.
    }

    /**
     * @inheritDoc
     */
    public function write($string): int
    {
        // TODO: Implement write() method.
    }

    /**
     * @inheritDoc
     */
    public function isReadable(): bool
    {
        // TODO: Implement isReadable() method.
    }

    /**
     * @inheritDoc
     */
    public function read($length): string
    {
        // TODO: Implement read() method.
    }

    /**
     * @inheritDoc
     */
    public function getContents(): string
    {
        // TODO: Implement getContents() method.
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->getSize();
    }

    /**
     * @inheritDoc
     */
    public function position(): int
    {
        return $this->tell();
    }

    /**
     * @inheritDoc
     */
    public function end(): bool
    {
        return $this->eof();
    }

    /**
     * @inheritDoc
     */
    public function isDetached(): bool
    {
        // TODO: Implement isDetached() method.
    }

    /**
     * @inheritDoc
     */
    public function resource()
    {
        // TODO: Implement resource() method.
    }

    /**
     * @inheritDoc
     */
    public function timedOut(): bool
    {
        // TODO: Implement timedOut() method.
    }

    /**
     * @inheritDoc
     */
    public function blocked(): bool
    {
        // TODO: Implement blocked() method.
    }

    /**
     * @inheritDoc
     */
    public function unreadBytes(): int
    {
        // TODO: Implement unreadBytes() method.
    }

    /**
     * @inheritDoc
     */
    public function streamType(): string
    {
        // TODO: Implement streamType() method.
    }

    /**
     * @inheritDoc
     */
    public function wrapperType(): string
    {
        // TODO: Implement wrapperType() method.
    }

    /**
     * @inheritDoc
     */
    public function wrapperData(): mixed
    {
        // TODO: Implement wrapperData() method.
    }

    /**
     * @inheritDoc
     */
    public function mode(): string
    {
        // TODO: Implement mode() method.
    }

    /**
     * @inheritDoc
     */
    public function uri(): string
    {
        // TODO: Implement uri() method.
    }

    /**
     * @inheritDoc
     */
    public function isLocal(): bool
    {
        // TODO: Implement isLocal() method.
    }

    /**
     * @inheritDoc
     */
    public function isTTY(): bool
    {
        // TODO: Implement isTTY() method.
    }

    /**
     * @inheritDoc
     */
    public function meta(): Meta
    {
        // TODO: Implement meta() method.
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

}
