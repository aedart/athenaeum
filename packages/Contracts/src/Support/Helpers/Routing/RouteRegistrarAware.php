<?php

namespace Aedart\Contracts\Support\Helpers\Routing;

use Illuminate\Contracts\Routing\Registrar;

/**
 * Route Registrar Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Routing
 */
interface RouteRegistrarAware
{
    /**
     * Set route registrar
     *
     * @param Registrar|null $registrar Route Registrar instance
     *
     * @return self
     */
    public function setRouteRegistrar(?Registrar $registrar);

    /**
     * Get route registrar
     *
     * If no route registrar has been set, this method will
     * set and return a default route registrar, if any such
     * value is available
     *
     * @see getDefaultRouteRegistrar()
     *
     * @return Registrar|null route registrar or null if none route registrar has been set
     */
    public function getRouteRegistrar(): ?Registrar;

    /**
     * Check if route registrar has been set
     *
     * @return bool True if route registrar has been set, false if not
     */
    public function hasRouteRegistrar(): bool;

    /**
     * Get a default route registrar value, if any is available
     *
     * @return Registrar|null A default route registrar value or Null if no default value is available
     */
    public function getDefaultRouteRegistrar(): ?Registrar;
}
