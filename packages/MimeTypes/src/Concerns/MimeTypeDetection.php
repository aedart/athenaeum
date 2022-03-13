<?php

namespace Aedart\MimeTypes\Concerns;

use Aedart\Contracts\MimeTypes\Detector;
use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Contracts\MimeTypes\MimeType;
use Aedart\MimeTypes\Detector as MimeTypeDetector;
use Aedart\MimeTypes\Traits\MimeTypeDetectorTrait;
use Aedart\Support\Facades\IoCFacade;

/**
 * Concerns Mime-Type Detection
 *
 * @see \Aedart\Contracts\MimeTypes\Detectable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\MimeTypes\Concerns
 */
trait MimeTypeDetection
{
    use MimeTypeDetectorTrait;

    /**
     * Returns the data to be used for mime-type detection
     *
     * @see mimeType
     *
     * @return string|resource
     *
     * @throws MimeTypeDetectionException
     */
    abstract protected function mimeTypeData();

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
    public function mimeType(string|null $profile = null, array $options = []): MimeType
    {
        return $this
            ->getMimeTypeDetector()
            ->detect(
                $this->mimeTypeData(),
                $profile,
                $options
            );
    }

    /**
     * @inheritDoc
     */
    public function getDefaultMimeTypeDetector(): Detector|null
    {
        return IoCFacade::tryMake(Detector::class, new MimeTypeDetector());
    }
}
