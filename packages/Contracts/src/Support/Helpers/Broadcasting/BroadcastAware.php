<?php

namespace Aedart\Contracts\Support\Helpers\Broadcasting;

use Illuminate\Contracts\Broadcasting\Broadcaster;

/**
 * Broadcast Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Broadcasting
 */
interface BroadcastAware
{
    /**
     * Set broadcast
     *
     * @param Broadcaster|null $broadcaster Broadcaster instance
     *
     * @return self
     */
    public function setBroadcast(Broadcaster|null $broadcaster): static;

    /**
     * Get broadcast
     *
     * If no broadcast has been set, this method will
     * set and return a default broadcast, if any such
     * value is available
     *
     * @see getDefaultBroadcast()
     *
     * @return Broadcaster|null broadcast or null if none broadcast has been set
     */
    public function getBroadcast(): Broadcaster|null;

    /**
     * Check if broadcast has been set
     *
     * @return bool True if broadcast has been set, false if not
     */
    public function hasBroadcast(): bool;

    /**
     * Get a default broadcast value, if any is available
     *
     * @return Broadcaster|null A default broadcast value or Null if no default value is available
     */
    public function getDefaultBroadcast(): Broadcaster|null;
}
