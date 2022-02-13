<?php

namespace Aedart\Maintenance\Modes\Traits;

use Aedart\Support\Facades\IoCFacade;

/**
 * Maintenance Mode Manager Trait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Maintenance\Modes\Traits
 */
trait MaintenanceModeManagerTrait
{
    /**
     * Maintenance Mode Manager instance
     *
     * @var \Illuminate\Foundation\MaintenanceModeManager|\Aedart\Maintenance\Modes\FallbackManager|null
     */
    protected mixed $maintenanceModeManager = null;

    /**
     * Set maintenance mode manager
     *
     * @param  \Illuminate\Foundation\MaintenanceModeManager|\Aedart\Maintenance\Modes\FallbackManager|null  $manager  Maintenance Mode Manager instance
     *
     * @return self
     */
    public function setMaintenanceModeManager(mixed $manager): static
    {
        $this->maintenanceModeManager = $manager;

        return $this;
    }

    /**
     * Get maintenance mode manager
     *
     * If no maintenance mode manager has been set, this method will
     * set and return a default maintenance mode manager, if any such
     * value is available
     *
     * @return \Illuminate\Foundation\MaintenanceModeManager|\Aedart\Maintenance\Modes\FallbackManager|null maintenance mode manager or null if none maintenance mode manager has been set
     */
    public function getMaintenanceModeManager(): mixed
    {
        if (!$this->hasMaintenanceModeManager()) {
            $this->setMaintenanceModeManager($this->getDefaultMaintenanceModeManager());
        }
        return $this->maintenanceModeManager;
    }

    /**
     * Check if maintenance mode manager has been set
     *
     * @return bool True if maintenance mode manager has been set, false if not
     */
    public function hasMaintenanceModeManager(): bool
    {
        return isset($this->maintenanceModeManager);
    }

    /**
     * Get a default maintenance mode manager value, if any is available
     *
     * @return \Illuminate\Foundation\MaintenanceModeManager|\Aedart\Maintenance\Modes\FallbackManager|null A default maintenance mode manager value or Null if no default value is available
     */
    public function getDefaultMaintenanceModeManager(): mixed
    {
        $manager = IoCFacade::tryMake('Illuminate\Foundation\MaintenanceModeManager');
        if (!isset($manager)) {
            return IoCFacade::tryMake('Aedart\Maintenance\Modes\FallbackManager');
        }

        return $manager;
    }
}
