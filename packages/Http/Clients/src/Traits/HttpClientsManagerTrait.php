<?php

namespace Aedart\Http\Clients\Traits;

use Aedart\Contracts\Http\Clients\Manager;
use Aedart\Support\Facades\IoCFacade;

/**
 * Http Clients Manager Trait
 *
 * @see \Aedart\Contracts\Http\Clients\Managers\HttpClientsManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Traits
 */
trait HttpClientsManagerTrait
{
    /**
     * Http Clients Manager
     *
     * @var Manager|null
     */
    protected Manager|null $httpClientsManager = null;

    /**
     * Set http clients manager
     *
     * @param Manager|null $manager Http Clients Manager
     *
     * @return self
     */
    public function setHttpClientsManager(Manager|null $manager): static
    {
        $this->httpClientsManager = $manager;

        return $this;
    }

    /**
     * Get http clients manager
     *
     * If no http clients manager has been set, this method will
     * set and return a default http clients manager, if any such
     * value is available
     *
     * @return Manager|null http clients manager or null if none http clients manager has been set
     */
    public function getHttpClientsManager(): Manager|null
    {
        if (!$this->hasHttpClientsManager()) {
            $this->setHttpClientsManager($this->getDefaultHttpClientsManager());
        }
        return $this->httpClientsManager;
    }

    /**
     * Check if http clients manager has been set
     *
     * @return bool True if http clients manager has been set, false if not
     */
    public function hasHttpClientsManager(): bool
    {
        return isset($this->httpClientsManager);
    }

    /**
     * Get a default http clients manager value, if any is available
     *
     * @return Manager|null A default http clients manager value or Null if no default value is available
     */
    public function getDefaultHttpClientsManager(): Manager|null
    {
        return IoCFacade::tryMake(Manager::class);
    }
}
