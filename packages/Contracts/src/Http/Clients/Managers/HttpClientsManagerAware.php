<?php

namespace Aedart\Contracts\Http\Clients\Managers;

use Aedart\Contracts\Http\Clients\Manager;

/**
 * Http Clients Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Traits
 */
interface HttpClientsManagerAware
{
    /**
     * Set http clients manager
     *
     * @param Manager|null $manager Http Clients Manager
     *
     * @return self
     */
    public function setHttpClientsManager(Manager|null $manager): static;

    /**
     * Get http clients manager
     *
     * If no http clients manager has been set, this method will
     * set and return a default http clients manager, if any such
     * value is available
     *
     * @return Manager|null http clients manager or null if none http clients manager has been set
     */
    public function getHttpClientsManager(): Manager|null;

    /**
     * Check if http clients manager has been set
     *
     * @return bool True if http clients manager has been set, false if not
     */
    public function hasHttpClientsManager(): bool;

    /**
     * Get a default http clients manager value, if any is available
     *
     * @return Manager|null A default http clients manager value or Null if no default value is available
     */
    public function getDefaultHttpClientsManager(): Manager|null;
}
