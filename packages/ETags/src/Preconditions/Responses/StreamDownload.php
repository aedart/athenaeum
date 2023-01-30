<?php

namespace Aedart\ETags\Preconditions\Responses;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\Contracts\MimeTypes\Detectable;
use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Utils\Dates\DateTimeFormats;
use Aedart\Streams\FileStream;
use Illuminate\Contracts\Support\Responsable;
use LogicException;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Teapot\StatusCode\All as Status;

/**
 * Stream Download Response
 *
 * TODO: ...
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Responses
 */
class StreamDownload implements Responsable
{
    public function __construct(
        protected ResourceContext $resource,
        protected string|null $name = null,
        protected array $headers = [],
        protected int $bufferSize = BufferSizes::BUFFER_1MB
    ) {
    }

    public static function make(ResourceContext $resource, string|null $name = null, array $headers = [], int $bufferSize = BufferSizes::BUFFER_1MB): static
    {
        return new static($resource, $name, $headers, $bufferSize);
    }

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        $resource = $this->resource();
        $name = $this->name();
        $headers = $this->headers();

        // TODO: Process range... if requested
        if ($resource->mustProcessRange()) {
        }

        return $this->makeFullStreamDownload($resource, $name, $headers);
    }

    public function resource(): ResourceContext
    {
        return $this->resource;
    }

    public function name(): string|null
    {
        return $this->name;
    }

    public function withHeaders(array $headers = []): static
    {
        $this->headers = array_merge(
            $this->headers,
            $headers
        );

        return $this;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function withBufferSize(int $bytes): static
    {
        $this->bufferSize = $bytes;

        return $this;
    }

    public function bufferSize(): int
    {
        return $this->bufferSize;
    }

    public function makeFullStreamDownload(ResourceContext $resource, string|null $name = null, array $headers = [])
    {
        $stream = $this->resolveStream($resource);

        if ($resource->hasEtag() && !isset($headers['ETag'])) {
            $headers['ETag'] = $resource->etag()->toString();
        }

        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = $stream->mimeType();
        }

        if (!isset($headers['Content-Length'])) {
            $headers['Content-Length'] = $stream->getSize();
        }

        return $this->makeStreamDownloadResponse(function () use ($stream) {
            $this->outputStream($stream);
        }, $name, $this->resolveHeaders($resource, $headers));
    }

    protected function resolveHeaders(ResourceContext $resource, array $headers = []): array
    {
        $common = [
            'Accept-Ranges' => $resource->allowedRangeUnit(),
        ];

        if ($resource->hasLastModifiedDate()) {
            $common['Last-Modified'] = $resource->lastModifiedDate()->format(DateTimeFormats::RFC9110);
        }

        return array_merge($common, $headers);
    }

    /**
     * Output stream's content
     *
     * @param FileStream $stream
     * @param int|null $bufferSize [optional]
     * @param bool $close [optional]
     *
     * @return void
     *
     * @throws StreamException
     */
    protected function outputStream(FileStream $stream, int|null $bufferSize = null, bool $close = true)
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
     * Resolves and wraps resource's data into a file stream
     *
     * @param ResourceContext $resource
     *
     * @return FileStreamInterface & Detectable
     *
     * @throws StreamException
     * @throws LogicException If unable to resolve stream from resource context
     */
    protected function resolveStream(ResourceContext $resource): FileStreamInterface & Detectable
    {
        $data = $resource->data();

        return match (true) {
            is_resource($data) => FileStream::make($data),
            $data instanceof StreamInterface => FileStream::makeFrom($data),
            $data instanceof SymfonyFile => FileStream::open($data->getRealPath(), 'r'),
            $data instanceof FileStreamInterface => $data,
            is_string($data) && file_exists($data) => FileStream::open($data, 'r'),
            is_string($data) => FileStream::openMemory()->append($data)->positionToStart(),
            default => throw new LogicException('Unable to resolve file stream from resource context data')
        };
    }

    /**
     * Returns a new streamed response
     *
     * @param callable $streamCallback Callback that handles actual streaming of file contents
     * @param string|null $path [optional] File path (filename is automatically extracted)
     * @param array $headers [optional]
     * @param int $status [optional]
     *
     * @return StreamedResponse
     */
    protected function makeStreamDownloadResponse(
        callable $streamCallback,
        string|null $path = null,
        array $headers = [],
        int $status = Status::OK
    ): StreamedResponse {
        $path = isset($path)
            ? basename($path)
            : null;

        return response()
            ->streamDownload($streamCallback, $path, $headers)
            ->setStatusCode($status);
    }
}
