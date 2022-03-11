<?php

namespace Aedart\Streams;

use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Streams\Locks\Lockable;
use Aedart\Contracts\Streams\Stream as StreamInterface;
use Aedart\Contracts\Streams\Transactions\Transactions;
use Aedart\Streams\Concerns;
use Aedart\Streams\Exceptions\CannotCopyToTargetStream;
use Aedart\Streams\Exceptions\CannotOpenStream;
use Aedart\Streams\Exceptions\StreamException;

/**
 * File Stream
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams
 */
class FileStream extends Stream implements
    FileStreamInterface,
    Lockable,
    Transactions
{
    use Concerns\Locking;
    use Concerns\Transactions;

    /**
     * @inheritDoc
     */
    public static function open(string $filename, string $mode, bool $useIncludePath = false, $context = null): static
    {
        $stream = fopen($filename, $mode, $useIncludePath, $context);

        if ($stream === false) {
            throw new CannotOpenStream(sprintf('Stream could not be opened for %s (mode %s)', $filename, $mode));
        }

        return static::make($stream);
    }

    /**
     * @inheritDoc
     */
    public static function openMemory(string $mode = 'r+b', $context = null): static
    {
        return static::open('php://memory', $mode, false, $context);
    }

    /**
     * @inheritDoc
     */
    public static function openTemporary(string $mode = 'r+b', int|null $maximumMemory = null, $context = null): static
    {
        $filename = isset($maximumMemory)
            ? "php://temp/maxmemory:$maximumMemory"
            : 'php://temp';

        return static::open($filename, $mode, false, $context);
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        $resource = $this->detach();

        if (isset($resource) && is_resource($resource)) {
            fclose($resource);
        }
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
        $target = $target ?? static::openTemporary();

        $this->performCopy($target, $length, $offset);

        return $this;
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
    public function truncate(int $size, bool $moveToEnd = true): static
    {
        $this->assertNotDetached('Unable to truncate stream');

        if (ftruncate($this->resource(), $size) === false) {
            throw new StreamException(sprintf('Failed truncating stream to %d bytes', $size));
        }

        if ($moveToEnd) {
            return $this->positionAtEnd();
        }

        return $this;
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
    ): string
    {
        $msg = 'Unable to compute stream\'s hash';
        $this
            ->assertNotDetached($msg)
            ->assertIsReadable($msg);

        $context = hash_init($algo, $flags, $key, $options);

        $this->restorePositionAfter(function(StreamInterface $stream) use ($context) {
            $stream->rewind();

            hash_update_stream($context, $this->resource());
        });

        return hash_final($context, $binary);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Perform copy of this stream into given target
     *
     * @param  StreamInterface  $target
     * @param  int|null  $length  [optional]
     * @param  int  $offset  [optional]
     *
     * @return int Bytes copied
     *
     * @throws StreamException
     */
    protected function performCopy(StreamInterface $target, int|null $length = null, int $offset = 0): int
    {
        // Abort if this stream is detached or not readable
        $msg = 'Unable to copy to target stream';
        $this
            ->assertNotDetached($msg)
            ->assertIsReadable($msg);

        // Abort if target is not writable or detached
        if ($target->isDetached() || $target->isWritable()) {
            throw new CannotCopyToTargetStream('Target stream is either detached or not writable.');
        }

        $bytesCopied = stream_copy_to_stream(
            $this->resource(),
            $target->resource(),
            $length,
            $offset
        );

        if ($bytesCopied === false) {
            throw new StreamException('Copy operation failed. Streams might be blocked or otherwise invalid, or "length" and "offset" are invalid');
        }

        return $bytesCopied;
    }
}
