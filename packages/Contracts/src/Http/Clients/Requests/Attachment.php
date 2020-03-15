<?php


namespace Aedart\Contracts\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Illuminate\Contracts\Support\Arrayable;
use Psr\Http\Message\StreamInterface;

/**
 * Request Attachment
 *
 * Represents a single file or other type of attachment, which can
 * be sent by a request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests
 */
interface Attachment extends Arrayable
{
    /**
     * Set this attachment's form input name
     *
     * @param string $name
     *
     * @return self
     */
    public function name(string $name): self;

    /**
     * Get this attachment's form input name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set the attachment's Http headers
     *
     * Method will merge with existing headers, if any have previously
     * been set.
     *
     * @param array $headers [optional] Key-value pair
     *
     * @return self
     */
    public function headers(array $headers = []): self;

    /**
     * Get all the Http headers for this attachment
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Set this attachment's contents
     *
     * @param StreamInterface|resource|string $data
     *
     * @return self
     */
    public function contents($data): self;

    /**
     * Get this attachment's contents
     *
     * @return StreamInterface|resource|string|null
     */
    public function getContents();

    /**
     * Use given file as this attachment's contents
     *
     * Method will attempt to open given file and set
     * the contents using a resource
     *
     * @param string $path
     *
     * @return self
     *
     * @throws InvalidFilePathException
     */
    public function attachFile(string $path): self;

    /**
     * Set the attachment's filename to be used by a request
     *
     * @param string|null $name [optional]
     *
     * @return self
     */
    public function filename(?string $name = null): self;

    /**
     * Get the attachment's filename to be used by a request
     *
     * @return string|null
     */
    public function getFilename(): ?string;
}