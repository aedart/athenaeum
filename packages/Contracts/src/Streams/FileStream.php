<?php

namespace Aedart\Contracts\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\Stream as StreamInterface;
use Psr\Http\Message\StreamInterface as PsrStreamInterface;
use Psr\Http\Message\UploadedFileInterface as PsrUploadedFile;
use SplFileInfo;

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
     * @throws StreamException
     */
    public static function openFileInfo(SplFileInfo $file, string $mode, bool $useIncludePath = false, $context = null): static;

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
     * @throws StreamException
     */
    public static function openUploadedFile(
        PsrUploadedFile $file,
        bool $asCopy = false,
        string $mode = 'r+b',
        int|null $maximumMemory = null,
        int $bufferSize = BufferSizes::BUFFER_8KB,
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
     * **Note**: _Neither this stream nor the copy stream are rewound after copy operation!_
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
     * **Note**: _Neither this stream nor the target stream are rewound after copy operation!_
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
     * @throws StreamException
     */
    public function copyFrom(
        $source,
        int|null $length = null,
        int $offset = 0,
        int $bufferSize = BufferSizes::BUFFER_8KB
    ): static;

    /**
     * Append data at the end of this stream
     *
     * Unlike {@see write()} and {@see put()}, this method will automatically move
     * the position to the end, before appending data.
     *
     * **Warning**: _Method will {@see detach()} `$data`'s underlying resource, if `$data` is a
     * pure {@see PsrStreamInterface} instance! If you wish for a continued valid resource reference in your
     * stream instance, then you should use {@see copyFrom()}._
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
     * Synchronizes changes to the file
     *
     * @see https://www.php.net/manual/en/function.fsync.php
     * @see https://www.php.net/manual/en/function.fdatasync.php
     *
     * @param  bool  $withoutMeta  [optional] When `true` data is synchronized
     *                             to file, but without meta-data.
     *
     * @return self
     *
     * @throws StreamException
     */
    public function sync(bool $withoutMeta = false): static;

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

    /**
     * Returns filename, if available
     *
     * If a 'filename' has been specified in the stream's meta,
     * then it will be favoured. Otherwise, the basename of
     * {@see uri()} will be returned, if its known.
     *
     * @return string|null
     */
    public function filename(): string|null;
}
