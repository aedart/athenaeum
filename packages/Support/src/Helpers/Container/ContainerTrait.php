<?php

namespace Aedart\Support\Helpers\Container;

use Aedart\Support\Facades\IoCFacade;
use Illuminate\Contracts\Container\Container;

/**
 * Container Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Container\ContainerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Container
 */
trait ContainerTrait
{
    /**
     * IoC Service Container instance
     *
     * @var Container|null
     */
    protected Container|null $container = null;

    /**
     * Set container
     *
     * @param Container|null $container IoC Service Container instance
     *
     * @return self
     */
    public function setContainer(Container|null $container): static
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get container
     *
     * If no container has been set, this method will
     * set and return a default container, if any such
     * value is available
     *
     * @see getDefaultContainer()
     *
     * @return Container|null container or null if none container has been set
     */
    public function getContainer(): Container|null
    {
        if (!$this->hasContainer()) {
            $this->setContainer($this->getDefaultContainer());
        }
        return $this->container;
    }

    /**
     * Check if container has been set
     *
     * @return bool True if container has been set, false if not
     */
    public function hasContainer(): bool
    {
        return isset($this->container);
    }

    /**
     * Get a default container value, if any is available
     *
     * @return Container|null A default container value or Null if no default value is available
     */
    public function getDefaultContainer(): Container|null
    {
        return IoCFacade::tryMake(Container::class);
    }
}
