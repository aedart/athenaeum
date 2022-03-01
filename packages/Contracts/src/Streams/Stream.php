<?php

namespace Aedart\Contracts\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
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
     * Returns meta for this steam
     *
     * @return Meta
     */
    public function meta(): Meta;
}
