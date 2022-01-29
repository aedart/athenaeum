<?php

namespace Aedart\Contracts\Core\Helpers;

/**
 * Namespace Detector Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core\Helpers
 */
interface NamespaceDetectorAware
{
    /**
     * Set namespace detector
     *
     * @param NamespaceDetector|null $detector Application Namespace Detector
     *
     * @return self
     */
    public function setNamespaceDetector(NamespaceDetector|null $detector): static;

    /**
     * Get namespace detector
     *
     * If no namespace detector has been set, this method will
     * set and return a default namespace detector, if any such
     * value is available
     *
     * @return NamespaceDetector|null namespace detector or null if none namespace detector has been set
     */
    public function getNamespaceDetector(): NamespaceDetector|null;

    /**
     * Check if namespace detector has been set
     *
     * @return bool True if namespace detector has been set, false if not
     */
    public function hasNamespaceDetector(): bool;

    /**
     * Get a default namespace detector value, if any is available
     *
     * @return NamespaceDetector|null A default namespace detector value or Null if no default value is available
     */
    public function getDefaultNamespaceDetector(): NamespaceDetector|null;
}
