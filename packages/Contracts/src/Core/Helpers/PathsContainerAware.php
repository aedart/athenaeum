<?php

namespace Aedart\Contracts\Core\Helpers;

/**
 * Paths Container Aware
 *
 * @see \Aedart\Contracts\Core\Helpers\PathsContainer
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core\Helpers
 */
interface PathsContainerAware
{
    /**
     * Set paths container
     *
     * @param PathsContainer|null $container Paths Container
     *
     * @return self
     */
    public function setPathsContainer(?PathsContainer $container);

    /**
     * Get paths container
     *
     * If no paths container has been set, this method will
     * set and return a default paths container, if any such
     * value is available
     *
     * @return PathsContainer|null paths container or null if none paths container has been set
     */
    public function getPathsContainer(): ?PathsContainer;

    /**
     * Check if paths container has been set
     *
     * @return bool True if paths container has been set, false if not
     */
    public function hasPathsContainer(): bool;

    /**
     * Get a default paths container value, if any is available
     *
     * @return PathsContainer|null A default paths container value or Null if no default value is available
     */
    public function getDefaultPathsContainer(): ?PathsContainer;
}
