<?php

namespace Aedart\Streams\Concerns;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\Stream as StreamInterface;
use Aedart\Streams\Exceptions\InvalidStreamResource;
use Psr\Http\Message\StreamInterface as PsrStreamInterface;

/**
 * Concerns Wrapping
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Concerns
 */
trait Wrapping
{
    /**
     * Wraps given data into a stream
     *
     * **Warning**: _Method will {@see detach()} `$data`'s underlying resource, if `$data` is a
     * pure {@see PsrStreamInterface} instance! If you wish for a continued valid resource reference in your
     * stream instance, then you should wrap `$data` into a {@see Stream} instance using {@see Stream::makeFrom()}._
     *
     * @param  string|int|float|resource|PsrStreamInterface|StreamInterface  $data
     * @param  int|null  $maximumMemory  [optional] When content is a string, then it will be wrapped into
     *                                   a temporary stream using {@see openTemporary()}, with given
     *                                   maximum amount of bytes, before written to a file by PHP.
     * @param  resource|null  $context  [optional]
     *
     * @return StreamInterface
     *
     * @throws InvalidStreamResource
     * @throws StreamException
     */
    protected function wrap($data, int|null $maximumMemory = null, $context = null): StreamInterface
    {
        return match (true) {
            is_string($data) || is_numeric($data) => $this->wrapRawData($data, $maximumMemory, $context),
            is_resource($data) => $this->wrapResource($data),
            $data instanceof StreamInterface => $data,
            $data instanceof PsrStreamInterface => $this->wrapPsrStream($data),
            default => throw new InvalidStreamResource('Unable to convert data to stream. Data appears to be invalid')
        };
    }

    /**
     * Wraps raw data into a stream
     *
     * @param  string|int|float  $data
     * @param  int|null  $maximumMemory  [optional] See {@see openTemporary()}
     * @param  resource|null  $context  [optional]
     *
     * @return StreamInterface
     *
     * @throws StreamException
     */
    protected function wrapRawData(string|int|float $data, int|null $maximumMemory = null, $context = null): StreamInterface
    {
        return static::openTemporary('r+b', $maximumMemory, $context)
            ->put((string) $data)
            ->positionToStart();
    }

    /**
     * Wraps a resource into a stream
     *
     * @param resource $resource
     *
     * @return StreamInterface
     *
     * @throws StreamException
     */
    protected function wrapResource($resource): StreamInterface
    {
        return static::make($resource);
    }

    /**
     * Wraps a {@see PsrStreamInterface} instance into a stream
     *
     * **Warning**: _Method will {@see detach()} underlying resource from given stream,
     * before creating a new stream instance!_
     *
     * @see Stream::makeFrom()
     *
     * @param  PsrStreamInterface  $stream
     *
     * @return StreamInterface
     */
    protected function wrapPsrStream(PsrStreamInterface $stream): StreamInterface
    {
        return static::makeFrom($stream);
    }
}
