<?php

namespace Aedart\Contracts\Streams;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\Meta\Repository;
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
     * @param  array|Repository|null  $meta  [optional]
     *
     * @return static
     *
     * @throws StreamException
     */
    public static function make($stream, array|Repository|null $meta = null): static;

    /**
     * Creates a new stream instance using underlying resource from given
     * stream object.
     *
     * **Warning**: _Method will {@see detach()} underlying resource from given stream,
     * before creating a new stream instance!_
     *
     * @param  StreamInterface  $stream Psr-7 Stream instance
     * @param  array|Repository|null  $meta  [optional]
     *
     * @return static
     *
     * @throws StreamException
     */
    public static function makeFrom(StreamInterface $stream, array|Repository|null $meta = null): static;

    /**
     * Returns a line from stream's content until end-of-line is reached
     *
     * @see https://www.php.net/manual/en/function.fgets.php
     * @see readLineUntil
     *
     * @param  int|null  $length  [optional]
     *
     * @return string|null Line contents or null when no more data to read (EOF)
     *
     * @throws StreamException
     */
    public function readLine(int|null $length = null): string|null;

    /**
     * Returns a line from stream's content until length, delimiter is reached,
     * or end-of-line is reached.
     *
     * @see https://www.php.net/manual/en/function.stream-get-line
     * @see readLine
     *
     * @param  int  $length Maximum amount of bytes to read. If 0 is given, then
     *                      default chunk size is applied (8 Kb)
     * @param  string  $ending  [optional] Line ending delimiter
     *
     * @return string|null Line contents or null when no more data to read (EOF)
     *
     * @throws StreamException
     */
    public function readLineUntil(int $length, string $ending = ''): string|null;
    
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
     * Determine if stream is a local stream
     *
     * @see https://www.php.net/manual/en/function.stream-is-local.php
     *
     * @return bool
     */
    public function isLocal(): bool;

    /**
     * Determine if stream is a TTY
     *
     * @see https://www.php.net/manual/en/function.stream-isatty.php
     *
     * @return bool
     */
    public function isTTY(): bool;

    /**
     * Returns meta for this steam
     *
     * @return Repository
     */
    public function meta(): Repository;
}
