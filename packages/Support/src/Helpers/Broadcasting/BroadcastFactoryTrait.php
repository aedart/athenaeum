<?php

namespace Aedart\Support\Helpers\Broadcasting;

use Illuminate\Contracts\Broadcasting\Factory;
use Illuminate\Support\Facades\Broadcast;

/**
 * Broadcast Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Broadcasting\BroadcastFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Broadcasting
 */
trait BroadcastFactoryTrait
{
    /**
     * Broadcast Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $broadcastFactory = null;

    /**
     * Set broadcast factory
     *
     * @param Factory|null $factory Broadcast Factory instance
     *
     * @return self
     */
    public function setBroadcastFactory(Factory|null $factory): static
    {
        $this->broadcastFactory = $factory;

        return $this;
    }

    /**
     * Get broadcast factory
     *
     * If no broadcast factory has been set, this method will
     * set and return a default broadcast factory, if any such
     * value is available
     *
     * @see getDefaultBroadcastFactory()
     *
     * @return Factory|null broadcast factory or null if none broadcast factory has been set
     */
    public function getBroadcastFactory(): Factory|null
    {
        if (!$this->hasBroadcastFactory()) {
            $this->setBroadcastFactory($this->getDefaultBroadcastFactory());
        }
        return $this->broadcastFactory;
    }

    /**
     * Check if broadcast factory has been set
     *
     * @return bool True if broadcast factory has been set, false if not
     */
    public function hasBroadcastFactory(): bool
    {
        return isset($this->broadcastFactory);
    }

    /**
     * Get a default broadcast factory value, if any is available
     *
     * @return Factory|null A default broadcast factory value or Null if no default value is available
     */
    public function getDefaultBroadcastFactory(): Factory|null
    {
        return Broadcast::getFacadeRoot();
    }
}
