<?php

namespace Aedart\Core\Traits;

use Aedart\Contracts\Core\Helpers\NamespaceDetector;

/**
 * Namespace Detector Trait
 *
 * @see \Aedart\Contracts\Core\Helpers\NamespaceDetectorAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Traits
 */
trait NamespaceDetectorTrait
{
    /**
     * Application Namespace Detector
     *
     * @var NamespaceDetector|null
     */
    protected ?NamespaceDetector $namespaceDetector = null;

    /**
     * Set namespace detector
     *
     * @param NamespaceDetector|null $detector Application Namespace Detector
     *
     * @return self
     */
    public function setNamespaceDetector(?NamespaceDetector $detector)
    {
        $this->namespaceDetector = $detector;

        return $this;
    }

    /**
     * Get namespace detector
     *
     * If no namespace detector has been set, this method will
     * set and return a default namespace detector, if any such
     * value is available
     *
     * @return NamespaceDetector|null namespace detector or null if none namespace detector has been set
     */
    public function getNamespaceDetector(): ?NamespaceDetector
    {
        if (!$this->hasNamespaceDetector()) {
            $this->setNamespaceDetector($this->getDefaultNamespaceDetector());
        }
        return $this->namespaceDetector;
    }

    /**
     * Check if namespace detector has been set
     *
     * @return bool True if namespace detector has been set, false if not
     */
    public function hasNamespaceDetector(): bool
    {
        return isset($this->namespaceDetector);
    }

    /**
     * Get a default namespace detector value, if any is available
     *
     * @return NamespaceDetector|null A default namespace detector value or Null if no default value is available
     */
    public function getDefaultNamespaceDetector(): ?NamespaceDetector
    {
        return null;
    }
}
