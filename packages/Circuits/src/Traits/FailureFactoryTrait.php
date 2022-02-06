<?php

namespace Aedart\Circuits\Traits;

use Aedart\Contracts\Circuits\Failures\Factory;
use Aedart\Support\Facades\IoCFacade;

/**
 * Failure Factory Trait
 *
 * @see \Aedart\Contracts\Circuits\Failures\FailureFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Traits
 */
trait FailureFactoryTrait
{
    /**
     * Failure Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $failureFactory = null;

    /**
     * Set failure factory
     *
     * @param Factory|null $factory Failure Factory instance
     *
     * @return self
     */
    public function setFailureFactory(Factory|null $factory): static
    {
        $this->failureFactory = $factory;

        return $this;
    }

    /**
     * Get failure factory
     *
     * If no failure factory has been set, this method will
     * set and return a default failure factory, if any such
     * value is available
     *
     * @return Factory|null failure factory or null if none failure factory has been set
     */
    public function getFailureFactory(): Factory|null
    {
        if (!$this->hasFailureFactory()) {
            $this->setFailureFactory($this->getDefaultFailureFactory());
        }
        return $this->failureFactory;
    }

    /**
     * Check if failure factory has been set
     *
     * @return bool True if failure factory has been set, false if not
     */
    public function hasFailureFactory(): bool
    {
        return isset($this->failureFactory);
    }

    /**
     * Get a default failure factory value, if any is available
     *
     * @return Factory|null A default failure factory value or Null if no default value is available
     */
    public function getDefaultFailureFactory(): Factory|null
    {
        return IoCFacade::tryMake(Factory::class);
    }
}
