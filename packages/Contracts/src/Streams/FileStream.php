<?php

namespace Aedart\Contracts\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Psr\Http\Message\StreamInterface;

/**
 * File Stream
 *
 * A wrapper of common stream operations on a file, which can be locally or
 * remote.
 *
 * @see \Aedart\Contracts\Streams\Stream
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams
 */
interface FileStream extends Stream
{
    /**
     * Open file or URL and wrap the resource into a new stream instance
     *
     * Method is a wrapper for PHP's {@see fopen()}.
     *
     * @see https://www.php.net/manual/en/function.fopen
     *
     * @param  string  $filename
     * @param  string  $mode
     * @param  bool  $useIncludePath  [optional]
     * @param  resource|null  $context  [optional]
     *
     * @return static
     *
     * @throws StreamException If unable to open file or URL
     */
    public static function open(
        string $filename,
        string $mode,
        bool $useIncludePath = false,
        $context = null
    ): static;

    /**
     * Open a stream to 'php://memory' and wrap the resource into a new stream instance
     *
     * @see open
     * @see https://www.php.net/manual/en/wrappers.php.php
     *
     * @param  string  $mode  [optional]
     * @param  resource|null  $context  [optional]
     *
     * @return static
     *
     * @throws StreamException
     */
    public static function openMemory(string $mode = 'w+b', $context = null): static;

    /**
     * Open a stream to 'php://temp' and wrap the resource into a new stream instance
     *
     * @see open
     * @see https://www.php.net/manual/en/wrappers.php.php
     *
     * @param  string  $mode  [optional]
     * @param  int|null  $maxMemory  [optional] Maximum amount of data to keep in memory before using a temporary file, in bytes
     * @param  resource|null  $context  [optional]
     *
     * @return static
     *
     * @throws StreamException
     */
    public static function openTemporary(string $mode = 'w+b', int|null $maxMemory = null, $context = null): static;

    /**
     * Copy this stream into another stream
     *
     * @see https://www.php.net/manual/en/function.stream-copy-to-stream.php
     *
     * @param  Stream|null  $target  [optional] If `null` is given, then a new stream instance
     *                              is automatically created, using {@see openMemory()}
     * @param  int|null  $length  [optional] Maximum bytes to copy. By default, all bytes left are copied
     * @param  int  $offset  [optional] The offset where to start to copy data
     *
     * @return static
     *
     * @throws StreamException
     */
    public function copy(Stream|null $target = null, int|null $length = null, int $offset = 0): static;

    /**
     * Write content at the end of this stream's data
     *
     * @param  string|resource|StreamInterface $content
     * @param  int  $bufferSize  [optional] Size of buffer in bytes for reading and writing.
     *
     * @return int Number of bytes written
     *
     * @throws StreamException
     */
    public function append($content, int $bufferSize = BufferSizes::BUFFER_8KB): int;

    /**
     * Write content at the beginning of this stream's data
     *
     * @param  string|resource|StreamInterface $content
     * @param  int  $bufferSize  [optional] Size of buffer in bytes for reading and writing.
     *
     * @return int Number of bytes written
     *
     * @throws StreamException
     */
    public function prepend($content, int $bufferSize = BufferSizes::BUFFER_8KB): int;

    /**
     * Truncates file pointer / stream to given size length
     *
     * @see https://www.php.net/manual/en/function.ftruncate
     *
     * @param  int  $size
     *
     * @return self
     *
     * @throws StreamException
     */
    public function truncate(int $size): static;

    /**
     * Synchronizes changes to the file
     *
     * @see https://www.php.net/manual/en/function.fsync.php
     * @see https://www.php.net/manual/en/function.fdatasync.php
     *
     * @param  bool  $includeMeta  [optional] When `true`, meta-data is also
     *                             synchronized to file.
     *
     * @return self
     *
     * @throws StreamException
     */
    public function sync(bool $includeMeta = true): static;
}
