<?php

namespace Aedart\Contracts\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Countable;
use Psr\Http\Message\StreamInterface;
use Stringable;

/**
 * Stream
 *
 * A wrapper of common stream operations; an extended version
 * of Psr's {@see StreamInterface}.
 *
 * @see \Psr\Http\Message\StreamInterface
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams
 */
interface Stream extends StreamInterface,
    Countable,
    Stringable
{
    /**
     * Creates a new stream instance for given resource
     *
     * @param  resource  $stream
     * @param  array|Meta|null  $meta  [optional]
     *
     * @return static
     *
     * @throws StreamException
     */
    public static function make($stream, array|Meta|null $meta = null): static;

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
     * Alias for {@see tell()}
     *
     * @return int
     *
     * @throws StreamException
     */
    public function position(): int;

    /**
     * Alias for {@see eof()}
     *
     * @return bool
     */
    public function end(): bool;

    /**
     * Determine if stream is detached
     *
     * @see detach
     *
     * @return bool
     */
    public function isDetached(): bool;

    /**
     * Returns the underlying PHP stream, if not detached
     *
     * @return resource|null
     */
    public function resource();

    /**
     * Determine if stream has timed out whilst waiting
     * for data
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return bool
     */
    public function timedOut(): bool;

    /**
     * Determine if stream is in blocking IO mode
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return bool
     */
    public function blocked(): bool;

    /**
     * Returns number of bytes currently in PHP's own internal buffer
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return int
     */
    public function unreadBytes(): int;

    /**
     * Returns a label that describes the underlying stream implementation
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return string
     */
    public function streamType(): string;

    /**
     * Returns a label that describes the protocol wrapper
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return string
     */
    public function wrapperType(): string;

    /**
     * Returns wrapper specific data that is attached to this stream
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return mixed
     */
    public function wrapperData(): mixed;

    /**
     * Returns stream's access model
     *
     * @see https://www.php.net/manual/en/function.fopen.php
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return string
     */
    public function mode(): string;

    /**
     * Returns the URI or filename associated with stream
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return string
     */
    public function uri(): string;

    /**
     * Returns meta for this steam
     *
     * @return Meta
     */
    public function meta(): Meta;
}
