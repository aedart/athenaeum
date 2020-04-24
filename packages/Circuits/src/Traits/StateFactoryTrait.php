<?php

namespace Aedart\Circuits\Traits;

use Aedart\Contracts\Circuits\States\Factory;
use Aedart\Support\Facades\IoCFacade;

/**
 * State Factory Trait
 *
 * @see \Aedart\Contracts\Circuits\States\StateFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Traits
 */
trait StateFactoryTrait
{
    /**
     * State Factory instance
     *
     * @var Factory|null
     */
    protected ?Factory $stateFactory = null;

    /**
     * Set state factory
     *
     * @param Factory|null $factory State Factory instance
     *
     * @return self
     */
    public function setStateFactory(?Factory $factory)
    {
        $this->stateFactory = $factory;

        return $this;
    }

    /**
     * Get state factory
     *
     * If no state factory has been set, this method will
     * set and return a default state factory, if any such
     * value is available
     *
     * @return Factory|null state factory or null if none state factory has been set
     */
    public function getStateFactory(): ?Factory
    {
        if (!$this->hasStateFactory()) {
            $this->setStateFactory($this->getDefaultStateFactory());
        }
        return $this->stateFactory;
    }

    /**
     * Check if state factory has been set
     *
     * @return bool True if state factory has been set, false if not
     */
    public function hasStateFactory(): bool
    {
        return isset($this->stateFactory);
    }

    /**
     * Get a default state factory value, if any is available
     *
     * @return Factory|null A default state factory value or Null if no default value is available
     */
    public function getDefaultStateFactory(): ?Factory
    {
        return IoCFacade::tryMake(Factory::class);
    }
}
