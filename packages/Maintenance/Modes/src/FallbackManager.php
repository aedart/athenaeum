<?php

namespace Aedart\Maintenance\Modes;

use Aedart\Maintenance\Modes\Drivers\ArrayBasedMode;
use Aedart\Maintenance\Modes\Drivers\JsonFileBasedMode;
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
     * Creates an instance of the json file based maintenance mode driver
     *
     * @return JsonFileBasedMode
     */
    protected function createJsonDriver(): JsonFileBasedMode
    {
        return new JsonFileBasedMode(
            storage_path('framework/down.json')
        );
    }

    /**
     * @inheritDoc
     */
    public function getDefaultDriver()
    {
        return $this->config->get('app.maintenance.driver', 'json');
    }
}
