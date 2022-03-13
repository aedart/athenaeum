<?php

namespace Aedart\Contracts\MimeTypes\Detectors;

use Aedart\Contracts\MimeTypes\Detector;

/**
 * Mime-Type Detector Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\MimeTypes\Detectors
 */
interface MimeTypeDetectorAware
{
    /**
     * Set mime type detector
     *
     * @param  Detector|null  $detector  Mime-Type Detector instance
     *
     * @return self
     */
    public function setMimeTypeDetector(Detector|null $detector): static;

    /**
     * Get mime type detector
     *
     * If no mime type detector has been set, this method will
     * set and return a default mime type detector, if any such
     * value is available
     *
     * @return Detector|null mime type detector or null if none mime type detector has been set
     */
    public function getMimeTypeDetector(): Detector|null;

    /**
     * Check if mime type detector has been set
     *
     * @return bool True if mime type detector has been set, false if not
     */
    public function hasMimeTypeDetector(): bool;

    /**
     * Get a default mime type detector value, if any is available
     *
     * @return Detector|null A default mime type detector value or Null if no default value is available
     */
    public function getDefaultMimeTypeDetector(): Detector|null;
}
