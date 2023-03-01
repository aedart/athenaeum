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
use Psr\Http\Message\UploadedFileInterface as PsrUploadedFile;
use SplFileInfo;
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
     * Open a new file stream for a PHP SplFileInfo instance
     *
     * Method attempts to set `filename` in meta, if SplFileInfo instance
     * has a "getClientOriginalName" (Laravel / Symfony Uploaded File instance).
     *
     * @see filename()
     * @see https://www.php.net/manual/en/class.splfileinfo.php
     *
     * @param  SplFileInfo  $file
     * @param  string  $mode
     * @param  bool  $useIncludePath  [optional]
     * @param  resource|null  $context  [optional]
     *
     * @return static
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public static function openFileInfo(SplFileInfo $file, string $mode, bool $useIncludePath = false, $context = null): static
    {
        $stream = static::open(
            filename: $file->getRealPath(),
            mode: $mode,
            useIncludePath: $useIncludePath,
            context: $context
        );

        // In case that a Laravel / Symfony Uploaded File instance is given, then
        // we can obtain an "original" filename, which should be used instead.
        if (method_exists($file, 'getClientOriginalName')) {
            $stream->meta()->set('filename', $file->getClientOriginalName());
        }

        return $stream;
    }

    /**
     * Open a new file stream for {@see PsrUploadedFile}
     *
     * **Warning**: _Method will {@see detach()} underlying resource from given stream,
     * before creating a new file stream instance, **unless** `$asCopy` is set to true._
     *
     * Method attempts to set `filename` in meta, from given Uploaded File's
     * {@see PsrUploadedFile::getClientFilename}.
     *
     * @see filename()
     *
     * @param PsrUploadedFile $file
     * @param bool $asCopy [optional] If true, then uploaded file's stream is copied (original stream is not detached).
     * @param string $mode [optional] Only applicable if `$asCopy` is true.
     * @param int|null $maximumMemory [optional] Maximum amount of bytes to keep in memory before writing to a temporary
     *                                file. If none specified, then defaults to 2 Mb. Only applicable if `$asCopy` is true.
     * @param int $bufferSize [optional] Read/Write size of copied chunk in bytes. Only applicable if `$asCopy` is true.
     * @param resource|null $context [optional] Only applicable if `$asCopy` is true.
     *
     * @return static
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    public static function openUploadedFile(
        PsrUploadedFile $file,
        bool $asCopy = false,
        string $mode = 'r+b',
        int|null $maximumMemory = null,
        int $bufferSize = BufferSizes::BUFFER_8KB,
        $context = null
    ): static {
        // Detach or copy uploaded file's stream
        $stream = (!$asCopy)
            ? static::makeFrom($file->getStream())
            : static::openTemporary($mode, $maximumMemory, $context)
                ->copyFrom(source: $file->getStream(), bufferSize: $bufferSize);

        // Set the "client" filename in meta...
        $stream->meta()->set('filename', $file->getClientFilename());

        return $stream;
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

    /**
     * Returns filename, if available
     *
     * If a 'filename' has been specified in the stream's meta,
     * then it will be favoured. Otherwise, the basename of
     * {@see uri()} will be returned, if its known.
     *
     * @return string|null
     */
    public function filename(): string|null
    {
        $meta = $this->getMetadata('filename');
        if (isset($meta)) {
            return $meta;
        }

        $uri = $this->uri();
        if ($uri === 'unknown') {
            return null;
        }

        return basename($uri);
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
