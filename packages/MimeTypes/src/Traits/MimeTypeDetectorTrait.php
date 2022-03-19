<?php

namespace Aedart\MimeTypes\Traits;

use Aedart\Contracts\MimeTypes\Detector;
use Aedart\Support\Facades\IoCFacade;

/**
 * Mime-Type Detector Trait
 *
 * @see \Aedart\Contracts\MimeTypes\Detectors\MimeTypeDetectorAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\MimeTypes\Traits
 */
trait MimeTypeDetectorTrait
{
    /**
     * Mime-Type Detector instance
     *
     * @var Detector|null
     */
    protected Detector|null $mimeTypeDetector = null;

    /**
     * Set mime type detector
     *
     * @param  Detector|null  $detector  Mime-Type Detector instance
     *
     * @return self
     */
    public function setMimeTypeDetector(Detector|null $detector): static
    {
        $this->mimeTypeDetector = $detector;

        return $this;
    }

    /**
     * Get mime type detector
     *
     * If no mime type detector has been set, this method will
     * set and return a default mime type detector, if any such
     * value is available
     *
     * @return Detector|null mime type detector or null if none mime type detector has been set
     */
    public function getMimeTypeDetector(): Detector|null
    {
        if (!$this->hasMimeTypeDetector()) {
            $this->setMimeTypeDetector($this->getDefaultMimeTypeDetector());
        }
        return $this->mimeTypeDetector;
    }

    /**
     * Check if mime type detector has been set
     *
     * @return bool True if mime type detector has been set, false if not
     */
    public function hasMimeTypeDetector(): bool
    {
        return isset($this->mimeTypeDetector);
    }

    /**
     * Get a default mime type detector value, if any is available
     *
     * @return Detector|null A default mime type detector value or Null if no default value is available
     */
    public function getDefaultMimeTypeDetector(): Detector|null
    {
        return IoCFacade::tryMake(Detector::class);
    }
}
