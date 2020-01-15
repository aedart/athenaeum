<?php

namespace Aedart\Core\Traits;

use Aedart\Container\Facades\IoCFacade;
use Aedart\Contracts\Core\Helpers\PathsContainer;

/**
 * Paths Container Trait
 *
 * @see \Aedart\Contracts\Core\Helpers\PathsContainerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Traits
 */
trait PathsContainerTrait
{
    /**
     * Paths Container
     *
     * @var PathsContainer|null
     */
    protected ?PathsContainer $pathsContainer = null;

    /**
     * Set paths container
     *
     * @param PathsContainer|null $container Paths Container
     *
     * @return self
     */
    public function setPathsContainer(?PathsContainer $container)
    {
        $this->pathsContainer = $container;

        return $this;
    }

    /**
     * Get paths container
     *
     * If no paths container has been set, this method will
     * set and return a default paths container, if any such
     * value is available
     *
     * @return PathsContainer|null paths container or null if none paths container has been set
     */
    public function getPathsContainer(): ?PathsContainer
    {
        if (!$this->hasPathsContainer()) {
            $this->setPathsContainer($this->getDefaultPathsContainer());
        }
        return $this->pathsContainer;
    }

    /**
     * Check if paths container has been set
     *
     * @return bool True if paths container has been set, false if not
     */
    public function hasPathsContainer(): bool
    {
        return isset($this->pathsContainer);
    }

    /**
     * Get a default paths container value, if any is available
     *
     * @return PathsContainer|null A default paths container value or Null if no default value is available
     */
    public function getDefaultPathsContainer(): ?PathsContainer
    {
        return IoCFacade::tryMake(PathsContainer::class);
    }
}
