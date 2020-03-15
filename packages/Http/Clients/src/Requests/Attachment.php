<?php

namespace Aedart\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Requests\Attachment as AttachmentInterface;
use Aedart\Http\Clients\Exceptions\InvalidFilePath;
use Psr\Http\Message\StreamInterface;

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
    protected ?string $filename = null;

    /**
     * Attachment constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name($name);
    }

    /**
     * @inheritDoc
     */
    public function name(string $name): AttachmentInterface
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
    public function headers(array $headers = []): AttachmentInterface
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
    public function contents($data): AttachmentInterface
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
    public function attachFile(string $path): AttachmentInterface
    {
        if (!file_exists($path)) {
            throw new InvalidFilePath(sprintf('Cannot attach file %s, please check your path', $path));
        }

        return $this->contents(fopen($path, 'r'));
    }

    /**
     * @inheritDoc
     */
    public function filename(?string $name = null): AttachmentInterface
    {
        $this->filename = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFilename(): ?string
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
}
