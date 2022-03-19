<?php

namespace Aedart\Contracts\MimeTypes;

use Aedart\Contracts\MimeTypes\Detectors\MimeTypeDetectorAware;
use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;

/**
 * Detectable
 *
 * File Component is able to detect its mime-type.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\MimeTypes
 */
interface Detectable extends MimeTypeDetectorAware
{
    /**
     * Detect mime-type of this file
     *
     * @param  string|null  $profile  [optional] Name of profile driver to use. If none is given,
     *                                then a default driver will be used.
     * @param  array  $options  [optional] Driver specific options
     *
     * @return MimeType
     *
     * @throws MimeTypeDetectionException
     */
    public function mimeType(string|null $profile = null, array $options = []): MimeType;
}
