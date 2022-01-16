<?php

namespace Aedart\Maintenance\Modes;

use Aedart\Maintenance\Modes\Drivers\ArrayBasedMode;
use Illuminate\Support\Manager;

/**
 * Fallback Maintenance Mode Manager
 *
 * Intended to be used when outside the scope of normal Laravel Application,
 * in which a Maintenance Mode Manager might not be available.
 *
 * @see \Illuminate\Foundation\MaintenanceModeManager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Maintenance\Modes
 */
class FallbackManager extends Manager
{
    /**
     * Creates an instance of the array based maintenance mode driver
     *
     * @return ArrayBasedMode
     */
    protected function createArrayDriver(): ArrayBasedMode
    {
        return new ArrayBasedMode();
    }

    /**
     * @inheritDoc
     */
    public function getDefaultDriver()
    {
        return $this->config->get('app.maintenance.driver', 'array');
    }
}
