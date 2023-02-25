<?php

namespace Aedart\ETags\Preconditions\Responses;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Preconditions\Ranges\RangeSet;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\Contracts\MimeTypes\Detectable;
use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Support\Helpers\Routing\ResponseFactoryAware;
use Aedart\Contracts\Utils\Dates\DateTimeFormats;
use Aedart\Streams\FileStream;
use Aedart\Support\Helpers\Routing\ResponseFactoryTrait;
use Aedart\Utils\Str;
use DateTimeInterface;
use Illuminate\Contracts\Support\Responsable;
use Psr\Http\Message\StreamInterface;
use Ramsey\Collection\CollectionInterface;
use RuntimeException;
use SplFileInfo;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Teapot\StatusCode\All as Status;

/**
 * Download Stream (Response Helper)
 *
 * @see https://httpwg.org/specs/rfc9110.html#status.206
 * @see https://httpwg.org/specs/rfc9110.html#multipart.byteranges
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
     * @var CollectionInterface<RangeSet>|null
     */
    protected CollectionInterface|null $ranges = null;

    /**
     * Http Content-Disposition
     *
     * @var string Either "inline" or "attachment"
     */
    protected string $disposition;

    /**
     * Custom resolve stream callback
     *
     * @var callable|null
     */
    protected $resolveStreamCallback = null;

    /**
     * Boundary separator for when streaming multiple parts
     *
     * @var string|null
     */
    protected string|null $boundary = null;

    /**
     * Creates a new download stream instance
     *
     * @param mixed|null $attachment [optional] The file to be attached to be streamed
     * @param string|null $name [optional] Filename
     * @param ETag|null $etag [optional] Attachment ETag
     * @param DateTimeInterface|null $lastModified [optional] Last modified date of attachment
     * @param CollectionInterface|null $ranges [optional] Requested ranges
     * @param string $disposition [optional] Http Content-Disposition, either "inline" or "attachment"
     * @param string $acceptRanges [optional] Accept Ranges Http header value
     * @param array $headers [optional] Http headers
     * @param int $bufferSize [optional] Attachment / File read buffer size (PHP) in bytes
     */
    public function __construct(
        mixed $attachment = null,
        string|null $name = null,
        ETag|null $etag = null,
        DateTimeInterface|null $lastModified = null,
        CollectionInterface|null $ranges = null,
        string $disposition = 'attachment',
        string $acceptRanges = 'bytes',
        array $headers = [],
        int $bufferSize = BufferSizes::BUFFER_1MB
    ) {
        $this->initHeaderBag();

        $this
            ->withAttachment($attachment)
            ->setName($name)
            ->withEtag($etag)
            ->setLastModifiedDate($lastModified)
            ->withRanges($ranges)
            ->setDisposition($disposition)
            ->withAcceptRanges($acceptRanges)
            ->withHeaders($headers)
            ->withBufferSize($bufferSize);
    }

    /**
     * Returns a new download stream instance
     *
     * @param mixed|null $attachment [optional] The file to be attached to be streamed
     * @param string|null $name [optional] Filename
     * @param ETag|null $etag [optional] Attachment ETag
     * @param DateTimeInterface|null $lastModified [optional] Last modified date of attachment
     * @param CollectionInterface|null $ranges [optional] Requested ranges
     * @param string $disposition [optional] Http Content-Disposition, either "inline" or "attachment"
     * @param string $acceptRanges [optional] Accept Ranges Http header value
     * @param array $headers [optional] Http headers
     * @param int $bufferSize [optional] Attachment / File read buffer size (PHP) in bytes
     *
     * @return static
     */
    public static function make(
        mixed $attachment = null,
        string|null $name = null,
        ETag|null $etag = null,
        DateTimeInterface|null $lastModified = null,
        CollectionInterface|null $ranges = null,
        string $disposition = 'attachment',
        string $acceptRanges = 'bytes',
        array $headers = [],
        int $bufferSize = BufferSizes::BUFFER_1MB
    ): static {
        return new static(
            attachment: $attachment,
            name: $name,
            etag: $etag,
            lastModified: $lastModified,
            ranges: $ranges,
            disposition: $disposition,
            acceptRanges: $acceptRanges,
            headers: $headers,
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
                        : null,
            acceptRanges: $resource->allowedRangeUnit()
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
        // Obtain stream for attachment
        $stream = $this->getStream();

        // [...] MUST generate the following header fields, [...], if the field would have been
        // sent in a 200 (OK) response to the same request: Date, Cache-Control, ETag, Expires,
        // Content-Location, and Vary. [...]
        // @see https://httpwg.org/specs/rfc9110.html#status.206
        // Symfony's Response Header Bag / Header Bag takes care of most of these...

        $headers = $this->resolveHeaders([
            'ETag' => $this->hasEtag()
                        ? (string) $this->etag()
                        : null,
            'Content-Length' => (int) $stream->getSize(), // bytes
            'Content-Type' => (string) $stream->mimeType(),
        ]);

        // Finally, create response
        return $this->makeStreamedResponse(function () use ($stream) {
            $this->outputEntireStream($stream);
        }, $this->name(), $headers->all(), $this->disposition());
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
        // Abort if no ranges available
        $ranges = $this->ranges();
        if (!isset($ranges) || $ranges->isEmpty()) {
            throw new RuntimeException('No ranges requested, unable to stream a single part');
        }

        // Obtain stream and range...
        $range = $ranges->first();
        $stream = $this->getStream();

        // [...] If a single part [...] the 206 response MUST generate a Content-Range header field,
        // describing what range of the selected representation is enclosed, and a content consisting
        // of the range [...]

        $headers = $this->resolveHeaders([
            'Content-Range' => $this->makeContentRange($range),
            'Content-Length' => $range->getLengthInBytes(),
            'Content-Type' => (string) $stream->mimeType(),
        ]);

        // Finally, create response
        return $this->makeStreamedResponse(function () use ($stream, $range) {
            $this->outputSingleRange($stream, $range);
        }, $this->name(), $headers->all(), $this->disposition(), Status::PARTIAL_CONTENT);
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
        // Abort if no ranges available
        $ranges = $this->ranges();
        if (!isset($ranges) || $ranges->isEmpty()) {
            throw new RuntimeException('No ranges requested, unable to stream a single part');
        }

        // Obtain stream and meta information...
        $stream = $this->getStream();
        $boundary = $this->boundary();
        $total = $this->contentLengthOfRanges($ranges); // Bytes

        // [...] If multiple parts are being transferred, the server [...] MUST generate "multipart/byteranges"
        // content, [...], and a Content-Type header field containing the "multipart/byteranges" media type and its
        // required boundary parameter. To avoid confusion with single-part responses, a server MUST NOT generate
        // a Content-Range header field in the HTTP header section of a multiple part response (this field will be
        // sent in each part instead). [...]

        $headers = $this->resolveHeaders([
            'Content-Length' => $total,

            // [...] Despite the name, the "multipart/byteranges" media type is not limited to byte ranges [...]
            'Content-Type' => "multipart/byteranges; boundary={$boundary}",
        ]);

        // Create the response
        return $this->makeStreamedResponse(function () use ($stream, $ranges, $boundary) {
            $this->outputMultipleRanges($stream, $ranges, $boundary);
        }, $this->name(), $headers->all(), $this->disposition(), Status::PARTIAL_CONTENT);
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
     * Returns the Http headers for the response
     *
     * @return array
     */
    public function headers(): array
    {
        return $this->headers->all();
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
     * @param  CollectionInterface<RangeSet>|null  $ranges  [optional]
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
     * @return CollectionInterface<RangeSet>|null
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
     * Set the range unit value for the Accept-Ranges header
     *
     * This unit is ignored when {@see ranges()} returns a collection of
     * range sets.
     *
     * @param string $rangeUnit E.g. bytes
     *
     * @return self
     */
    public function withAcceptRanges(string $rangeUnit): static
    {
        return $this->header('Accept-Ranges', $rangeUnit);
    }

    /**
     * Get the range unit value for the Accept-Ranges header
     *
     * @return string
     */
    public function acceptRanges(): string
    {
        return $this->headers->get('Accept-Ranges', 'none');
    }

    /**
     * Set the boundary separator for when streaming multiple parts
     *
     * @param string|null $separator Separator without "--" (leading hyphens) prefix
     *
     * @return self
     */
    public function withBoundary(string|null $separator): static
    {
        // [...] Boundary delimiters [...] must be no longer than
        // 70 characters, not counting the two leading hyphens.
        // @see https://www.rfc-editor.org/rfc/rfc2046.html#section-5.1.1
        if (isset($separator) && strlen($separator) > 70) {
            throw new RuntimeException('Boundary separator is no allowed to be above 70 characters long');
        }

        $this->boundary = $separator;

        return $this;
    }

    /**
     * Get the boundary separator for when streaming multiple parts
     *
     * @return string The separator that was set or a generated separator, when
     *                none was set. Separator does NOT contain "--" (leading hyphens) prefix!
     */
    public function boundary(): string
    {
        return $this->boundary ?? $this->makeBoundarySeparator();
    }

    /**
     * Set custom callback to resolve stream for attachment
     *
     * @see getStream
     *
     * @param callable|null $callback Callback receives attachment and this download stream instance.
     *
     * @return self
     */
    public function setResolveStreamCallback(callable|null $callback): static
    {
        $this->resolveStreamCallback = $callback;

        return $this;
    }

    /**
     * Get custom callback to resolve stream for attachment
     *
     * @return callable|null
     */
    public function getResolveStreamCallback(): callable|null
    {
        return $this->resolveStreamCallback;
    }

    /**
     * Returns a file stream for the attachment
     *
     * @return FileStreamInterface & Detectable
     *
     * @throws StreamException
     * @throws RuntimeException
     */
    public function getStream(): FileStreamInterface & Detectable
    {
        $data = $this->attachment();
        if (!isset($data)) {
            throw new RuntimeException('Missing an attachment, unable to create file stream');
        }

        // Resolve stream using custom callback, if available.
        $callback = $this->getResolveStreamCallback();
        if (isset($callback)) {
            return $callback($data, $this);
        }

        // Otherwise, resolve it using the following...
        return match (true) {
            is_resource($data) => FileStream::make($data),
            $data instanceof FileStreamInterface => $data,
            $data instanceof StreamInterface => FileStream::makeFrom($data),
            $data instanceof SplFileInfo => FileStream::open($data->getRealPath(), 'r'),
            is_string($data) && file_exists($data) => FileStream::open($data, 'r'),
            default => throw new RuntimeException('Unable to resolve file stream from attachment')
        };
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Initialises a new Header bag for this download stream
     *
     * @return HeaderBag
     */
    protected function initHeaderBag(): HeaderBag
    {
        return $this->headers = $this->makeHeaderBag();
    }

    /**
     * Returns a new Header bag instance
     *
     * @param array $headers [optional]
     *
     * @return HeaderBag
     */
    protected function makeHeaderBag(array $headers = []): HeaderBag
    {
        return new ResponseHeaderBag($headers);
    }

    /**
     * Resolves Http headers for response
     *
     * @param array $common [optional] Common Http headers to set, if none already set!
     *                      NOTE: Empty headers will NOT be set.
     *
     * @return HeaderBag
     */
    protected function resolveHeaders(array $common = []): HeaderBag
    {
        // Make a new header bag with a copy of headers set.
        $headers = $this->makeHeaderBag(
            $this->headers()
        );

        // Always attempt to add last modified date, if available...
        if ($this->hasLastModifiedDate()) {
            $headers->set('Last-Modified', $this->lastModifiedDate()->format(DateTimeFormats::RFC9110));
        }

        // Set the given "common" Http headers, if none was already
        // specified in this download stream...
        foreach ($common as $key => $value) {
            // Skip a header was already set or value is null
            if ($headers->has($key) || is_null($value) || (is_string($value) && empty($value))) {
                continue;
            }

            $headers->set($key, $value);
        }

        return $headers;
    }

    /**
     * Returns a new streamed response instance
     *
     * @param callable $callback
     * @param string|null $name [optional]
     * @param array $headers [optional]
     * @param string $disposition [optional]
     * @param int $status [optional]
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function makeStreamedResponse(
        callable $callback,
        string|null $name = null,
        array $headers = [],
        string $disposition = 'attachment',
        int $status = Status::OK
    ) {
        $name = isset($name)
            ? basename($name)
            : null;

        return $this
            ->getResponseFactory()
            ->streamDownload(
                callback: $callback,
                name: $name,
                headers: $headers,
                disposition: $disposition
            )
            ->setStatusCode($status);
    }

    /**
     * Output stream's content
     *
     * @param FileStreamInterface $stream
     * @param int|null $bufferSize [optional]
     * @param bool $close [optional] If true, then the stream is closed after its content has been output
     *
     * @return void
     *
     * @throws StreamException
     */
    protected function outputEntireStream(FileStreamInterface $stream, int|null $bufferSize = null, bool $close = true): void
    {
        $bufferSize = $bufferSize ?? $this->bufferSize();
        $chunks = $stream->readAllInChunks($bufferSize);

        foreach ($chunks as $chunk) {
            echo $chunk;

            if (connection_aborted() === 1) {
                break;
            }
        }

        if ($close) {
            $stream->close();
        }
    }

    /**
     * Output a single ranges for given stream
     *
     * @param FileStreamInterface $stream
     * @param RangeSet $range
     * @param int|null $bufferSize [optional]
     * @param bool $close [optional]
     *
     * @return void
     *
     * @throws StreamException
     */
    protected function outputSingleRange(
        FileStreamInterface $stream,
        RangeSet $range,
        int|null $bufferSize = null,
        bool $close = true
    ): void {
        $chunks = $stream->buffer(
            length: $range->getLengthInBytes(),
            offset: $range->getStartBytes(),
            bufferSize: $bufferSize ?? $this->bufferSize()
        );

        foreach ($chunks as $chunk) {
            // Output chunk
            echo $chunk;

            // Abort loop if required...
            if (connection_aborted() === 1) {
                break;
            }
        }

        if ($close) {
            $stream->close();
        }
    }

    /**
     * Output multiple ranges for given stream
     *
     * @param FileStreamInterface&Detectable $stream
     * @param CollectionInterface $ranges
     * @param string $boundary
     * @param int|null $bufferSize [optional]
     * @param bool $close [optional]
     *
     * @return void
     *
     * @throws StreamException
     * @throws MimeTypeDetectionException
     */
    protected function outputMultipleRanges(
        FileStreamInterface & Detectable $stream,
        CollectionInterface $ranges,
        string $boundary,
        int|null $bufferSize = null,
        bool $close = true
    ): void {
        $bufferSize = $bufferSize ?? $this->bufferSize();
        $newLine = PHP_EOL;

        // Make separator. Note that the "--" prefix is required.
        // @see https://www.rfc-editor.org/rfc/rfc2046.html#section-5.1.1
        $separator = "--{$boundary}";

        // Resolve Content-Type for each body part. Use Content-Type from the headers,
        // if any was set. Otherwise, use stream's mime-type.
        // (Unable to use the "resolveHeaders()" here...)
        $mimeType = $this->headers->get('Content-Type', (string) $stream->mimeType());
        $contentType = "Content-Type: {$mimeType}";

        foreach ($ranges as $range) {
            /** @var RangeSet $range */

            // Output a newline, if this isn't the first range
            if ($range !== $ranges->first()) {
                echo $newLine;
            }

            // Output "header" for part. Example:
            // --separator_string (newline)
            // Content-Type: application/pdf (newline)
            // Content-Range: bytes 234-639/8000 (newline)
            // (newline)
            echo implode($newLine, [
                $separator,
                $contentType,
                'Content-Range: ' . $this->makeContentRange($range),
                $newLine
            ]);

            // Output range, but make sure NOT to close the stream here...
            $this->outputSingleRange(
                stream: $stream,
                range: $range,
                bufferSize: $bufferSize,
                close: false
            );

            // Abort loop if required...
            if (connection_aborted() === 1) {
                break;
            }
        }

        // [...] The boundary delimiter line following the last body part is a
        // distinguished delimiter that indicates that no further body parts
        // will follow. Such a delimiter line is identical to the previous
        // delimiter lines, with the addition of two more hyphens after the
        // boundary parameter value.
        // @see https://www.rfc-editor.org/rfc/rfc2046.html#section-5.1.1
        echo "{$newLine}{$separator}--";

        if ($close) {
            $stream->close();
        }
    }

    /**
     * Creates Content Range header value
     *
     * @see https://httpwg.org/specs/rfc9110.html#field.content-range
     *
     * @param RangeSet $range
     *
     * @return string E.g. bytes 21010-47021/47022
     */
    protected function makeContentRange(RangeSet $range): string
    {
        return $range->contentRange();
    }

    /**
     * Returns the total length requested
     *
     * @see acceptRanges()
     *
     * @param CollectionInterface<RangeSet> $ranges
     *
     * @return int In bytes
     */
    protected function contentLengthOfRanges(CollectionInterface $ranges): int
    {
        $total = 0;
        foreach ($ranges as $range) {
            /** @var RangeSet $range */
            $total += $range->getLengthInBytes();
        }

        return $total;
    }

    /**
     * Generates a new boundary separator
     *
     * @see https://www.rfc-editor.org/rfc/rfc2046.html#section-5.1.1
     *
     * @param int $length [optional] Max 70, acc. to rfc2046
     *
     * @return string Boundary separator without "--" (leading hyphens) prefix
     */
    protected function makeBoundarySeparator(int $length = 16): string
    {
        if ($length > 70) {
            throw new RuntimeException('Length of boundary cannot be more than 70 characters');
        }

        return Str::random($length);
    }
}
