<?php


namespace Aedart\Contracts\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Aedart\Contracts\Streams\Stream;
use Aedart\Contracts\Utils\Populatable;
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
interface Attachment extends Populatable,
    Arrayable
{
    /**
     * Set this attachment's form input name
     *
     * @param string $name
     *
     * @return self
     */
    public function name(string $name): static;

    /**
     * Get this attachment's form input name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set the attachment's Http headers
     *
     * @param array $headers [optional] Key-value pair
     *
     * @return self
     */
    public function headers(array $headers = []): static;

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
    public function contents($data): static;

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
    public function attachFile(string $path): static;

    /**
     * Use stream as this attachment's content
     *
     * @param Stream|resource $stream
     *
     * @return self
     */
    public function attachStream($stream): static;

    /**
     * Set the attachment's filename to be used by a request
     *
     * @param string|null $name [optional]
     *
     * @return self
     */
    public function filename(string|null $name = null): static;

    /**
     * Get the attachment's filename to be used by a request
     *
     * @return string|null
     */
    public function getFilename(): string|null;
}
