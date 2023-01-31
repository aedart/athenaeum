<?php

namespace Aedart\ETags\Preconditions\Responses;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Support\Helpers\Routing\ResponseFactoryAware;
use Aedart\Support\Helpers\Routing\ResponseFactoryTrait;
use DateTimeInterface;
use Illuminate\Contracts\Support\Responsable;
use Ramsey\Collection\CollectionInterface;
use Ramsey\Http\Range\Unit\UnitRangeInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Teapot\StatusCode\All as Status;

/**
 * Download Stream (Response Helper)
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Responses
 */
class DownloadStream implements
    Responsable,
    ResponseFactoryAware
{
    use ResponseFactoryTrait;

    /**
     * The attachment to be streamed
     *
     * @var mixed
     */
    protected mixed $attachment;

    /**
     * Filename
     *
     * @var string|null
     */
    protected string|null $name = null;

    /**
     * Response Http headers
     *
     * @var HeaderBag
     */
    protected HeaderBag $headers;

    /**
     * Attachment / File read buffer size
     *
     * @var int
     */
    protected int $bufferSize;

    /**
     * Etag of attachment, if any available
     *
     * @var ETag|null
     */
    protected ETag|null $etag = null;

    /**
     * Attachment's last modified date
     *
     * @var DateTimeInterface|null
     */
    protected DateTimeInterface|null $lastModified = null;

    /**
     * Requested range sets
     *
     * @var CollectionInterface<UnitRangeInterface>|null
     */
    protected CollectionInterface|null $ranges = null;

    /**
     * The range unit to use for full attachment stream
     *
     * @var string E.g. bytes
     */
    protected string $rangeUnit;

    /**
     * Http Content-Disposition
     *
     * @var string Either "inline" or "attachment"
     */
    protected string $disposition;

    /**
     * Creates a new download stream instance
     *
     * @param mixed|null $attachment [optional] The file to be attached to be streamed
     * @param string|null $name [optional] Filename
     * @param array $headers [optional] Http headers
     * @param ETag|null $etag [optional] Attachment ETag
     * @param DateTimeInterface|null $lastModified [optional] Last modified date of attachment
     * @param CollectionInterface|null $ranges [optional] Requested ranges
     * @param string $disposition [optional] Http Content-Disposition, either "inline" or "attachment"
     * @param string $rangeUnit [optional] Range unit to use for full attachment stream. Ignored if $ranges provided
     * @param int $bufferSize [optional] Attachment / File read buffer size (PHP)
     *
     */
    public function __construct(
        mixed $attachment = null,
        string|null $name = null,
        array $headers = [],
        ETag|null $etag = null,
        DateTimeInterface|null $lastModified = null,
        CollectionInterface|null $ranges = null,
        string $disposition = 'attachment',
        string $rangeUnit = 'bytes',
        int $bufferSize = BufferSizes::BUFFER_1MB
    ) {
        $this->initHeaderBag();

        $this
            ->withAttachment($attachment)
            ->setName($name)
            ->withHeaders($headers)
            ->withEtag($etag)
            ->setLastModifiedDate($lastModified)
            ->withRanges($ranges)
            ->setDisposition($disposition)
            ->withRangeUnit($rangeUnit)
            ->withBufferSize($bufferSize);
    }

    /**
     * Returns a new download stream instance
     *
     * @param mixed|null $attachment [optional] The file to be attached to be streamed
     * @param string|null $name [optional] Filename
     * @param array $headers [optional] Http headers
     * @param ETag|null $etag [optional] Attachment ETag
     * @param DateTimeInterface|null $lastModified [optional] Last modified date of attachment
     * @param CollectionInterface|null $ranges [optional] Requested ranges
     * @param string $disposition [optional] Http Content-Disposition, either "inline" or "attachment"
     * @param string $rangeUnit [optional] Range unit to use for full attachment stream. Ignored if $ranges provided
     * @param int $bufferSize [optional] Attachment / File read buffer size (PHP)
     *
     * @return static
     */
    public static function make(
        mixed $attachment = null,
        string|null $name = null,
        array $headers = [],
        ETag|null $etag = null,
        DateTimeInterface|null $lastModified = null,
        CollectionInterface|null $ranges = null,
        string $disposition = 'attachment',
        string $rangeUnit = 'bytes',
        int $bufferSize = BufferSizes::BUFFER_1MB
    ): static
    {
        return new static(
            attachment: $attachment,
            name: $name,
            headers: $headers,
            etag: $etag,
            lastModified: $lastModified,
            ranges: $ranges,
            disposition: $disposition,
            rangeUnit: $rangeUnit,
            bufferSize: $bufferSize
        );
    }

    /**
     * Returns a new download stream instance for given resource
     *
     * @param ResourceContext $resource
     *
     * @return static
     */
    public static function for(ResourceContext $resource): static
    {
        return static::make(
            attachment: $resource->data(),
            etag: $resource->etag(),
            lastModified: $resource->lastModifiedDate(),
            ranges: $resource->mustProcessRange()
                        ? $resource->ranges()
                        : null
        );
    }

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        $mustStreamRanges = $this->mustStreamRanges();
        $amountRanges = optional($this->ranges())->count() ?? 0;

        // Stream single part...
        if ($mustStreamRanges && $amountRanges === 1) {
            return $this->streamSinglePart($request);
        }

        // Stream multiple parts...
        if ($mustStreamRanges && $amountRanges > 1) {
            return $this->streamMultipleParts($request);
        }

        // Stream entire attachment...
        return $this->streamFullAttachment($request);
    }

    /**
     * Returns a "200 Ok" response that streams the entire attachment
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function streamFullAttachment($request)
    {
        // TODO ... full damn headers, assert attachment, get stream... etc...
    }

    /**
     * Returns a "206 Partial Content" response for a single requested range
     *
     * @see https://httpwg.org/specs/rfc9110.html#partial.single
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function streamSinglePart($request)
    {
        // TODO
    }

    /**
     * Returns a "206 Partial Content" response for a multiple requested ranges
     *
     * @see https://httpwg.org/specs/rfc9110.html#partial.multipart
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function streamMultipleParts($request)
    {
        // TODO
    }

    /**
     * Set the attachment to be streamed
     *
     * @param mixed $file
     *
     * @return self
     */
    public function withAttachment(mixed $file): static
    {
        $this->attachment = $file;

        return $this;
    }

    /**
     * Get the attachment to be streamed
     *
     * @return mixed
     */
    public function attachment(): mixed
    {
        return $this->attachment;
    }

    /**
     * Set the filename for the response
     *
     * @param string|null $name
     *
     * @return self
     */
    public function setName(string|null $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the filename for the response
     *
     * @return string|null
     */
    public function name(): string|null
    {
        return $this->name;
    }

    /**
     * Set the Http Content-Disposition
     *
     * @param string $disposition Either "inline" or "attachment"
     *
     * @return self
     */
    public function setDisposition(string $disposition): static
    {
        $this->disposition = $disposition;

        return $this;
    }

    /**
     * Get the Http Content-Disposition
     *
     * @return string Either "inline" or "attachment"
     */
    public function disposition(): string
    {
        return $this->disposition;
    }

    /**
     * Set the response's Content-Disposition to "inline"
     *
     * @return self
     */
    public function asInlineDisposition(): static
    {
        return $this->setDisposition('inline');
    }

    /**
     * Set the response's Content-Disposition to "attachment"
     *
     * @return self
     */
    public function asAttachmentDisposition(): static
    {
        return $this->setDisposition('attachment');
    }

    /**
     * Set the attachment file read buffer size in bytes
     *
     * @param int $bytes
     *
     * @return self
     */
    public function withBufferSize(int $bytes): static
    {
        $this->bufferSize = $bytes;

        return $this;
    }

    /**
     * Get the attachment file read buffer size in bytes
     *
     * @return int
     */
    public function bufferSize(): int
    {
        return $this->bufferSize;
    }

    /**
     * Set a header for the response
     *
     * @param string $key
     * @param string|array|null $values
     * @param bool $replace [optional] Replace actual value of header, if true.
     *
     * @return self
     */
    public function header(string $key, string|array|null $values, bool $replace = true): static
    {
        $this->headers->set($key, $values, $replace);

        return $this;
    }

    /**
     * Add multiple headers to the response
     *
     * @param \Symfony\Component\HttpFoundation\HeaderBag|array $headers
     *
     * @return self
     */
    public function withHeaders($headers): static
    {
        if ($headers instanceof HeaderBag) {
            $headers = $headers->all();
        }

        foreach ($headers as $key => $value) {
            $this->headers->set($key, $value);
        }

        return $this;
    }

    /**
     * Set attachment's ETag
     *
     * @param ETag|null $etag
     *
     * @return self
     */
    public function withEtag(ETag|null $etag): static
    {
        $this->etag = $etag;

        return $this;
    }

    /**
     * Get attachment's ETag
     *
     * @return ETag|null
     */
    public function etag(): ETag|null
    {
        return $this->etag;
    }

    /**
     * Determine if attachment has an ETag
     *
     * @return bool
     */
    public function hasEtag(): bool
    {
        return isset($this->etag);
    }

    /**
     * Set the attachment's last modified date
     *
     * @param DateTimeInterface|null $lastModified
     *
     * @return self
     */
    public function setLastModifiedDate(DateTimeInterface|null $lastModified): static
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get the attachment's last modified date
     *
     * @return DateTimeInterface|null
     */
    public function lastModifiedDate(): DateTimeInterface|null
    {
        return $this->lastModified;
    }

    /**
     * Determine if attachment has a last modification date
     *
     * @return bool
     */
    public function hasLastModifiedDate(): bool
    {
        return isset($this->lastModified);
    }

    /**
     * Set the requested range sets for attachment
     *
     * @param  CollectionInterface<UnitRangeInterface>|null  $ranges  [optional]
     *
     * @return self
     */
    public function withRanges(CollectionInterface|null $ranges = null): static
    {
        $this->ranges = $ranges;

        return $this;
    }

    /**
     * Get the requested range sets for attachment
     *
     * @return CollectionInterface<UnitRangeInterface>|null
     */
    public function ranges(): CollectionInterface|null
    {
        return $this->ranges;
    }

    /**
     * Determine range sets must be streamed
     *
     * @return bool
     */
    public function mustStreamRanges(): bool
    {
        return isset($this->ranges) && !$this->ranges->isEmpty();
    }

    /**
     * Set the range unit to use for full attachment stream
     *
     * This unit is ignored when {@see ranges()} returns a collection of
     * range sets.
     *
     * @param string $unit E.g. bytes
     *
     * @return self
     */
    public function withRangeUnit(string $unit): static
    {
        $this->rangeUnit = $unit;

        return $this;
    }

    /**
     * Get the range unit to use for full attachment stream
     *
     * @return string
     */
    public function rangeUnit(): string
    {
        return $this->rangeUnit;
    }

    /**
     * Returns a file stream for the attachment
     *
     * @return FileStreamInterface
     */
    public function getStream(): FileStreamInterface
    {
        // TODO:
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns a new Header bag instance
     *
     * @return HeaderBag
     */
    protected function initHeaderBag(): HeaderBag
    {
        return $this->headers = new ResponseHeaderBag();
    }
}