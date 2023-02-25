<?php

namespace Aedart\Streams;

use Aedart\Contracts\MimeTypes\Detectable;
use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Streams\Hashing\Hashable;
use Aedart\Contracts\Streams\Locks\Lockable;
use Aedart\Contracts\Streams\Stream as StreamInterface;
use Aedart\Contracts\Streams\Transactions\Transactions;
use Aedart\MimeTypes\Concerns\MimeTypeDetection;
use Aedart\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Streams\Exceptions\CannotCopyToTargetStream;
use Aedart\Streams\Exceptions\CannotOpenStream;
use Aedart\Streams\Exceptions\InvalidStreamResource;
use Aedart\Streams\Exceptions\StreamException;
use Psr\Http\Message\StreamInterface as PsrStreamInterface;
use Throwable;

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
    Transactions,
    Detectable
{
    use Concerns\Hashing;
    use Concerns\Locking;
    use Concerns\Transactions;
    use Concerns\Copying;
    use Concerns\Wrapping;
    use MimeTypeDetection;

    /**
     * @inheritDoc
     */
    public static function open(string $filename, string $mode, bool $useIncludePath = false, $context = null): static
    {
        try {
            $stream = fopen($filename, $mode, $useIncludePath, $context);
        } catch (Throwable $e) {
            throw new CannotOpenStream($e->getMessage(), $e->getCode(), $e);
        }

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

        $this->copySourceToTarget($this, $target, $length, $offset);

        return $target;
    }

    /**
     * Copy data from source stream into this stream
     *
     * **Note**: _Neither this stream nor the source stream are rewound after copy operation!_
     *
     * **{@see PsrStreamInterface}**: _Unlike {@see append()}, this method will NOT detach the stream's underlying resource._
     *
     * @param  resource|PsrStreamInterface|StreamInterface  $source  The source stream to copy from.
     * @param  int|null  $length  [optional] Maximum bytes to copy from source stream. By default, all bytes left are copied
     * @param  int  $offset  [optional] The offset on source stream where to start to copy data from
     * @param  int  $bufferSize  [optional] Read/Write size of each chunk in bytes.
     *                           Applicable ONLY if `$source` is instance of {@see PsrStreamInterface}.
     *
     * @return static This stream with data appended from source stream
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public function copyFrom(
        $source,
        int|null $length = null,
        int $offset = 0,
        int $bufferSize = BufferSizes::BUFFER_8KB
    ): static {
        // Obtain underlying resource, when a stream instance is provided.
        if ($source instanceof StreamInterface) {
            if ($source->isDetached() || !$source->isReadable()) {
                throw new CannotCopyToTargetStream('Source stream is either detached or not readable.');
            }

            $source = $source->resource();
        }

        // Copy the pure resource into this stream's underlying resource.
        if (is_resource($source)) {
            $this->copyRawResource(
                source: $source,
                target: $this->resource(),
                length: $length,
                offset: $offset
            );

            return $this;
        }

        // A PSR stream instance is a bit more tricky, because it's underlying resource
        // cannot be obtained, without detaching it. If so, we risk causing a defect in
        // outer logic/code, where this method is invoked.
        if ($source instanceof PsrStreamInterface) {
            $this->copyFromPsrStream(
                source: $source,
                target: $this,
                length: $length,
                offset: $offset,
                bufferSize: $bufferSize
            );

            return $this;
        }

        // Fail when source stream is not supported...
        throw new InvalidStreamResource('Unable to copy from unsupported source stream.');
    }

    /**
     * @inheritdoc
     */
    public function append(
        $data,
        int|null $length = null,
        int $offset = 0,
        int|null $maximumMemory = null
    ): static {
        $this
            ->positionToEnd()
            ->copySourceToTarget(
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
            return $this->positionToEnd();
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function sync(bool $withoutMeta = true): static
    {
        $this->assertNotDetached('Unable to synchronizes data to file');

        $result = ($withoutMeta)
            ? fdatasync($this->resource())
            : fsync($this->resource());

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
     * @inheritDoc
     */
    protected function mimeTypeData()
    {
        try {
            $this->assertNotDetached('Unable to obtain MIME-type data');

            return $this->resource();
        } catch (Throwable $e) {
            throw new MimeTypeDetectionException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
