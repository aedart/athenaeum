<?php

namespace Aedart\Contracts\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Psr\Http\Message\StreamInterface as PsrStreamInterface;

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
    public static function openMemory(string $mode = 'r+b', $context = null): static;

    /**
     * Open a stream to 'php://temp' and wrap the resource into a new stream instance
     *
     * @see open
     * @see https://www.php.net/manual/en/wrappers.php.php
     *
     * @param  string  $mode  [optional]
     * @param  int|null  $maximumMemory  [optional] Maximum amount of bytes to keep in memory before writing to a
     *                                   temporary file. If none specified, then defaults to 2 Mb.
     * @param  resource|null  $context  [optional]
     *
     * @return static
     *
     * @throws StreamException
     */
    public static function openTemporary(string $mode = 'r+b', int|null $maximumMemory = null, $context = null): static;

    /**
     * Copy this stream
     *
     * Method is the equivalent of invoking {@see copyTo()} without a `$target`.
     *
     * @see copyTo()
     *
     * @param  int|null  $length  [optional] Maximum bytes to copy. By default, all bytes left are copied
     * @param  int  $offset  [optional] The offset where to start to copy data
     *
     * @return static New stream created via {@see openTemporary()} with this stream's contents copied
     *
     * @throws StreamException
     */
    public function copy(int|null $length = null, int $offset = 0): static;

    /**
     * Copy this stream into another stream
     *
     * @see https://www.php.net/manual/en/function.stream-copy-to-stream.php
     *
     * @param  Stream|null  $target  [optional] Target stream to copy this stream's content into.
     *                               If `null` is given, then a new stream instance
     *                               is automatically created, using {@see openTemporary()}
     * @param  int|null  $length  [optional] Maximum bytes to copy. By default, all bytes left are copied
     * @param  int  $offset  [optional] The offset where to start to copy data
     *
     * @return static Provided target (the copied stream) with this stream's contents copied
     *
     * @throws StreamException
     */
    public function copyTo(Stream|null $target = null, int|null $length = null, int $offset = 0): static;

    /**
     * Append data at the end of this stream
     *
     * Unlike {@see write()} and {@see put()}, this method will automatically move
     * the position to the end, before appending data.
     *
     * **Warning**: _Method will {@see detach()} `$data`'s underlying resource, if `$data` is a
     * pure {@see PsrStreamInterface} instance! If you wish for a continued valid resource reference in your
     * stream instance, then you should wrap `$data` into a {@see Stream} instance using {@see Stream::makeFrom()}._
     *
     * @param  string|int|float|resource|PsrStreamInterface|Stream  $data
     * @param  int|null  $length  [optional] Maximum bytes to append. By default, all bytes left are appended
     * @param  int  $offset  [optional] The offset where to start to copy data (offset on `$data`)
     * @param  int|null  $maximumMemory  [optional] Maximum amount of bytes to keep in memory before writing to a
     *                                   temporary file. If none specified, then defaults to 2 Mb.
     *                                   Argument is only applied when `$data` is of type string or number.
     *
     * @return self
     *
     * @throws StreamException
     */
    public function append(
        $data,
        int|null $length = null,
        int $offset = 0,
        int|null $maximumMemory = null
    ): static;

    /**
     * Truncates file stream to given size length
     *
     * @see https://www.php.net/manual/en/function.ftruncate
     *
     * @param  int  $size
     * @param  bool  $moveToEnd  [optional] Moves position to the end of
     *                           the file after truncate, if set to `true`.
     *
     * @return self
     *
     * @throws StreamException
     */
    public function truncate(int $size, bool $moveToEnd = true): static;

    /**
     * TODO: Only available from for PHP v8.1 and upwards
     * TODO: @see https://github.com/aedart/athenaeum/issues/105
     *
     * Synchronizes changes to the file
     *
     * @see https://www.php.net/manual/en/function.fsync.php
     * @see https://www.php.net/manual/en/function.fdatasync.php
     *
     * @param  bool  $includeMeta  [optional] When `true`, meta-data is also
     *                             synchronized to file.
     *                             If `false`, meta-data is not synchronized
     *                             (works only on POSIX systems).
     *
     * @return self
     *
     * @throws StreamException
     */
//    public function sync(bool $includeMeta = true): static;

    /**
     * Writes all buffered output to the open file
     *
     * @see https://www.php.net/manual/en/function.fflush.php
     *
     * @return self
     *
     * @throws StreamException
     */
    public function flush(): static;
}
