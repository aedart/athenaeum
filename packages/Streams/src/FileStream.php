<?php

namespace Aedart\Streams;

use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Streams\Hashing\Hashable;
use Aedart\Contracts\Streams\Locks\Lockable;
use Aedart\Contracts\Streams\Stream as StreamInterface;
use Aedart\Contracts\Streams\Transactions\Transactions;
use Aedart\Streams\Concerns;
use Aedart\Streams\Exceptions\CannotCopyToTargetStream;
use Aedart\Streams\Exceptions\CannotOpenStream;
use Aedart\Streams\Exceptions\InvalidStreamResource;
use Aedart\Streams\Exceptions\StreamException;

/**
 * File Stream
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams
 */
class FileStream extends Stream implements
    FileStreamInterface,
    Hashable,
    Lockable,
    Transactions
{
    use Concerns\Hashing;
    use Concerns\Locking;
    use Concerns\Transactions;
    use Concerns\Conversion;

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

        $this->performCopy($this, $target, $length, $offset);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function append(
        $data,
        int|null $length = null,
        int $offset = 0,
        int|null $maximumMemory = null
    ): static
    {
        $this
            ->positionAtEnd()
            ->performCopy(
                $this->wrap($data, $maximumMemory),
                $this,
                $length,
                $offset
            );

        return $this;
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
     * {@inheritDoc}
     *
     * **CAUTION**: _Method is only supported from PHP v8.1_
     * TODO: @see https://github.com/aedart/athenaeum/issues/105
     */
    public function sync(bool $includeMeta = true): static
    {
        $this->assertNotDetached('Unable to synchronizes data to file');

        if ($includeMeta) {
            $result = fsync($this->resource());
        } else {
            $result = fdatasync($this->resource());
        }

        if ($result === false) {
            throw new StreamException('Failed to synchronize data to file. Please check if stream is block or otherwise invalid');
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function flush(): static
    {
        $this->assertNotDetached('Unable to flush output');

        if (fflush($this->resource()) === false) {
            throw new StreamException('Flush output failed. Please check if stream is block or otherwise invalid');
        }

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Perform copy of this stream into given target
     *
     * @param  StreamInterface  $source
     * @param  StreamInterface  $target
     * @param  int|null  $length  [optional]
     * @param  int  $offset  [optional]
     *
     * @return int Bytes copied
     *
     * @throws StreamException
     */
    protected function performCopy(StreamInterface $source, StreamInterface $target, int|null $length = null, int $offset = 0): int
    {
        // Abort if source is detached or not readable
        if ($source->isDetached() || !$target->isReadable()) {
            throw new CannotCopyToTargetStream('Source stream is either detached or not readable.');
        }

        // Abort if target is not writable or detached
        if ($target->isDetached() || !$target->isWritable()) {
            throw new CannotCopyToTargetStream('Target stream is either detached or not writable.');
        }

        $bytesCopied = stream_copy_to_stream(
            $source->resource(),
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
