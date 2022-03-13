<?php

namespace Aedart\Contracts\MimeTypes;

use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;

/**
 * Mime-Type Detector
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\MimeTypes
 */
interface Detector
{
    /**
     * Detect mime-type based on given data
     *
     * @param  string|resource  $data  Content of a file
     * @param  string|null  $profile  [optional] Name of profile driver to use. If none is given,
     *                                then a default driver will be used.
     * @param  array  $options  [optional] Driver specific options
     *
     * @return MimeType
     *
     * @throws MimeTypeDetectionException
     */
    public function detect($data, string|null $profile = null, array $options = []): MimeType;

    /**
     * Creates a new {@see Sampler} instance
     *
     * @param  string|resource  $data  Content of a file to be used by sampler
     * @param  string|null  $profile  [optional] Name of profile driver to use. If none is given,
     *                                then a default driver will be used.
     * @param  array  $options  [optional] Driver specific options
     *
     * @return Sampler
     *
     * @throws MimeTypeDetectionException
     */
    public function makeSampler($data, string|null $profile = null, array $options = []): Sampler;
}
