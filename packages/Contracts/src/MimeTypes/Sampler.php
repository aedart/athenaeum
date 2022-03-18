<?php

namespace Aedart\Contracts\MimeTypes;

use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use InvalidArgumentException;

/**
 * Mime-Type Sampler
 *
 * Able to sample data to obtain mime-type information.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\MimeTypes
 */
interface Sampler
{
    /**
     * Returns a short description of the detected mime-type,
     * if available
     *
     * @return string|null
     *
     *
     * @throws MimeTypeDetectionException
     */
    public function getMimeTypeDescription(): string|null;

    /**
     * Detects the mime-type
     *
     * @return string|null
     *
     * @throws MimeTypeDetectionException
     */
    public function detectMimetype(): string|null;

    /**
     * Detects the mime encoding
     *
     * @return string|null
     *
     * @throws MimeTypeDetectionException
     */
    public function detectEncoding(): string|null;

    /**
     * Detects the mime-type and encoding as defined by RFC 2045
     *
     * @see https://datatracker.ietf.org/doc/html/rfc2045
     *
     * @return string|null
     *
     * @throws MimeTypeDetectionException
     */
    public function detectMime(): string|null;

    /**
     * Returns file-extensions that matches the detected mime-type
     *
     * **Note** _Some mime-types that are known to have multiple
     * extensions, e.g. JPEG images: jpeg, jpg, jpe, jfif, ...etc_
     *
     * @return string[]
     *
     * @throws MimeTypeDetectionException
     */
    public function detectFileExtensions(): array;

    /**
     * Returns the sample data used for detection of mime-type information
     *
     * Method returns sample of size specified by {@see getSampleSize()}.
     *
     * @return string
     *
     * @throws MimeTypeDetectionException
     */
    public function getSampleData(): string;

    /**
     * Returns the raw data this sampler uses
     *
     * @return mixed
     */
    public function getRawData(): mixed;

    /**
     * Set the maximum size of the contents sample to use for detection
     *
     * @param  int  $size Bytes. If `0` is given, then entire content
     *                    is used for detection.
     *
     * @return static
     *
     * @throws InvalidArgumentException
     */
    public function setSampleSize(int $size): static;

    /**
     * Returns the maximum size of the contents sample to use for detection
     *
     * @return int Bytes
     */
    public function getSampleSize(): int;
}
