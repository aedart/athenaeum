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
     * Open stream using a callback
     *
     * Method will fail, if stream is already opened!
     *
     * @param  callable  $callback Callback must return a resource
     *
     * @return self
     *
     * @throws StreamException
     */
    public function openUsing(callable $callback): static;

    /**
     * Returns a line from stream's content until length or newline is reached,
     * or end-of-file (EOF)
     *
     * @see https://www.php.net/manual/en/function.fgets.php
     * @see readLineUntil()
     *
     * @param  int|null  $length  [optional]
     *
     * @return string|false Line contents or false when no more data to read (EOF)
     *
     * @throws StreamException
     */
    public function readLine(int|null $length = null): string|false;

    /**
     * Returns a line from stream's content until length or delimiter is reached,
     * or end-of-file (EOF) is reached.
     *
     * @see https://www.php.net/manual/en/function.stream-get-line
     * @see readLine()
     *
     * @param  int  $length Maximum amount of bytes to read. If 0 is given, then
     *                      default chunk size is applied (8 Kb)
     * @param  string  $ending  [optional] Line ending delimiter
     *
     * @return string|false Line contents or false when no more data to read (EOF)
     *
     * @throws StreamException
     */
    public function readLineUntil(int $length, string $ending = ''): string|false;

    /**
     * Parse stream contents according to the specified format
     *
     * @see https://www.php.net/manual/en/function.fscanf
     *
     * @param  string  $format
     * @param  mixed  ...$vars
     *
     * @return array|int|false|null
     *
     * @throws StreamException
     */
    public function parse(string $format, mixed &...$vars): array|int|false|null;

    /**
     * Performs an operation and rewinds the position afterwards
     *
     * @param  callable  $operation Callback to invoke. This stream is given as callback argument
     *
     * @return mixed Callback return value, if any
     *
     * @throws StreamException
     */
    public function rewindAfter(callable $operation): mixed;

    /**
     * Apply a callback, when result is true
     *
     * Method is inverse of {@see unless}.
     *
     * Any value returned by the callback methods, is ignored.
     *
     * @param  bool|callable  $result E.g. the boolean result of a condition. If callback is given, then its
     *                              resulting value is used as result.
     * @param  callable  $callback The callback to apply, if result is `true`.
     *                          Stream instance is given as callback's argument.
     * @param  callable|null  $otherwise [optional] Callback to apply, if result evaluates is `false`.
     *                          Stream instance is given as callback's argument.
     *
     * @return self
     */
    public function when(bool|callable $result, callable $callback, callable|null $otherwise = null): static;

    /**
     * Apply a callback, unless result is true
     *
     * Method is inverse of {@see when}.
     *
     * Any value returned by the callback methods, is ignored.
     *
     * @param  bool|callable  $result E.g. the boolean result of a condition. If callback is given, then its
     *                              resulting value is used as result.
     * @param  callable  $callback The callback to apply, if result is `false`.
     *                          Stream instance is given as callback's argument.
     * @param  callable|null  $otherwise [optional] Callback to apply, if result evaluates is `true`.
     *                          Stream instance is given as callback's argument.
     *
     * @return self
     */
    public function unless(bool|callable $result, callable $callback, callable|null $otherwise = null): static;

    /**
     * Alias for {@see seek()}
     *
     * Method return this stream instance after seek operation
     * has been completed.
     *
     * @param  int  $offset
     * @param  int  $whence  [optional]
     *
     * @return self
     *
     * @throws StreamException
     */
    public function positionAt(int $offset, int $whence = SEEK_SET): static;

    /**
     * Move position to the beginning of the stream
     *
     * @return self
     *
     * @throws StreamException
     */
    public function positionAtStart(): static;

    /**
     * Move position to the end of the stream
     *
     * @return self
     *
     * @throws StreamException
     */
    public function positionAtEnd(): static;

    /**
     * Alias for {@see tell()}
     *
     * @return int
     *
     * @throws StreamException
     */
    public function position(): int;

    /**
     * Output all remaining data
     *
     * @see https://www.php.net/manual/en/function.fpassthru
     *
     * @return int Amount of characters read and passed through to output buffer
     *
     * @throws StreamException
     */
    public function passThrough(): int;

    /**
     * Set blocking or non-blocking mode for stream
     *
     * @see https://www.php.net/manual/en/function.stream-set-blocking.php
     *
     * @param  bool  $block True if stream must use blocking mode, false
     *                      if stream must use non-blocking mode
     *
     * @return self
     *
     * @throws StreamException
     */
    public function setBlocking(bool $block): static;

    /**
     * Set stream timeout
     *
     * @see https://www.php.net/manual/en/function.stream-set-timeout.php
     *
     * @param  int  $seconds
     * @param  int  $microseconds  [optional]
     *
     * @return self
     *
     * @throws StreamException
     */
    public function setTimeout(int $seconds, int $microseconds = 0): static;
    
    /**
     * Returns the underlying PHP stream, if not detached
     *
     * @return resource|null
     */
    public function resource();

    /**
     * Determine if stream is opened (not detached)
     *
     * @see isDetached()
     *
     * @return bool
     */
    public function isOpen(): bool;

    /**
     * Determine if stream is detached
     *
     * @see detach()
     *
     * @return bool
     */
    public function isDetached(): bool;

    /**
     * Determine if stream supports locking
     *
     * @see https://www.php.net/manual/en/function.stream-supports-lock
     *
     * @return bool
     *
     * @throws StreamException
     */
    public function supportsLocking(): bool;

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
     * Returns the id of the underlying resource
     *
     * @see https://www.php.net/manual/en/function.get-resource-id
     *
     * @return int
     *
     * @throws StreamException
     */
    public function id(): int;

    /**
     * Returns the type of the underlying resource
     *
     * @see https://www.php.net/manual/en/function.get-resource-type.php
     *
     * @return string
     *
     * @throws StreamException
     */
    public function type(): string;

    /**
     * Returns a label that describes the underlying stream implementation
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return string
     *
     * @throws StreamException
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
     *
     * @throws StreamException
     */
    public function isLocal(): bool;

    /**
     * Determine if stream is a TTY
     *
     * @see https://www.php.net/manual/en/function.stream-isatty.php
     *
     * @return bool
     *
     * @throws StreamException
     */
    public function isTTY(): bool;

    /**
     * Returns stream size as a human-readable string
     *
     * @see getSize()
     *
     * @param  int  $precision  [optional]
     *
     * @return string E.g. 12.72 MB
     */
    public function getFormattedSize(int $precision = 2): string;

    /**
     * Set the meta repository for this stream
     *
     * If a meta repository was previously set, then it will be
     * overwritten.
     *
     * @param  array|Repository|null  $meta  [optional] If an `array` is given, then it will be
     *                                       used to populate a new meta repository.
     *                                       Default to a new empty repository if `null` is given.
     *
     * @return self
     */
    public function setMetaRepository(array|Repository|null $meta = null): static;

    /**
     * Returns meta for this steam
     *
     * Method is responsible for refreshing available meta-data,
     * and merge it into the stream meta repository, before
     * returning it.
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     * @see rawMeta()
     *
     * @return Repository
     */
    public function meta(): Repository;

    /**
     * Returns the raw meta-data from the stream
     *
     * @see https://www.php.net/manual/en/function.stream-get-meta-data
     *
     * @return array
     */
    public function rawMeta(): array;

    /**
     * Debug info
     *
     * @return array
     */
    public function __debugInfo(): array;
}
