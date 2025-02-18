<?php

namespace Aedart\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Requests\Attachment as AttachmentInterface;
use Aedart\Contracts\Streams\Stream;
use Aedart\Http\Clients\Exceptions\InvalidFilePath;
use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Throwable;

/**
 * Request Attachment
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Attachment
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests
 */
class Attachment implements AttachmentInterface
{
    /**
     * Form input name
     *
     * @var string
     */
    protected string $name;

    /**
     * Http headers for attachment
     *
     * @var array
     */
    protected array $headers = [];

    /**
     * The contents of this attachment
     *
     * @var StreamInterface|resource|string|null
     */
    protected $contents;

    /**
     * Filename of attachment to be used by a
     * request
     *
     * @var string|null
     */
    protected string|null $filename = null;

    /**
     * Attachment constructor.
     *
     * @param array $data [optional]
     *
     * @throws Throwable
     */
    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    /**
     * @inheritDoc
     */
    public function populate(array $data = []): static
    {
        foreach ($data as $property => $value) {
            $this->populateProperty($property, $value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function headers(array $headers = []): static
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function contents($data): static
    {
        $this->contents = $data;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @inheritDoc
     */
    public function attachFile(string $path): static
    {
        if (!file_exists($path)) {
            throw new InvalidFilePath(sprintf('Cannot attach file %s, please check your path', $path));
        }

        return $this->contents(fopen($path, 'r'));
    }

    /**
     * @inheritdoc
     */
    public function attachStream($stream): static
    {
        if ($stream instanceof Stream) {
            $stream = $stream->detach();
        }

        return $this->contents($stream);
    }

    /**
     * @inheritDoc
     */
    public function filename(string|null $name = null): static
    {
        $this->filename = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFilename(): string|null
    {
        return $this->filename;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'headers' => $this->getHeaders(),
            'contents' => $this->getContents(),
            'filename' => $this->getFilename()
        ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Set a given property's value
     *
     * @param string $property
     * @param mixed $value
     *
     * @throws InvalidArgumentException If property does not exist
     */
    protected function populateProperty(string $property, $value)
    {
        if (!method_exists($this, $property)) {
            throw new InvalidArgumentException(sprintf('Property %s does not exist', $property));
        }

        $this->{$property}($value);
    }
}
