<?php

namespace Aedart\Streams;

use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Streams\Stream as StreamInterface;

/**
 * File Stream
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams
 */
class FileStream extends Stream implements FileStreamInterface
{
    /**
     * @inheritDoc
     */
    public static function open(string $filename, string $mode, bool $useIncludePath = false, $context = null): static
    {
        // TODO: Implement open() method.
    }

    /**
     * @inheritDoc
     */
    public static function openMemory(string $mode = 'r+b', $context = null): static
    {
        // TODO: Implement openMemory() method.
    }

    /**
     * @inheritDoc
     */
    public static function openTemporary(string $mode = 'r+b', int|null $maximumMemory = null, $context = null): static
    {
        // TODO: Implement openTemporary() method.
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
    public function copy(int|null $length = null, int $offset = 0): static
    {
        return $this->copyTo(null, $length, $offset);
    }

    /**
     * @inheritDoc
     */
    public function copyTo(StreamInterface|null $target = null, int|null $length = null, int $offset = 0): static
    {
        // TODO: Implement copyTo() method.
    }

    /**
     * @inheritDoc
     */
    public function append($content, int $bufferSize = BufferSizes::BUFFER_8KB): int
    {
        // TODO: Implement append() method.
    }

    /**
     * @inheritDoc
     */
    public function prepend($content, int $bufferSize = BufferSizes::BUFFER_8KB): int
    {
        // TODO: Implement prepend() method.
    }

    /**
     * @inheritDoc
     */
    public function truncate(int $size): static
    {
        // TODO: Implement truncate() method.
    }

    /**
     * @inheritDoc
     */
    public function sync(bool $includeMeta = true): static
    {
        // TODO: Implement sync() method.
    }

    /**
     * @inheritDoc
     */
    public function flush(): static
    {
        // TODO: Implement flush() method.
    }

    /**
     * @inheritDoc
     */
    public function hash(
        string $algo,
        bool $binary = false,
        int $flags = 0,
        string $key = '',
        array $options = []
    ): string {
        // TODO: Implement hash() method.
    }
}
