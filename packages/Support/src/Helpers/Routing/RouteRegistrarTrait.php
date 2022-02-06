<?php

namespace Aedart\Support\Helpers\Routing;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

/**
 * Route Registrar Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Routing\RouteRegistrarAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Routing
 */
trait RouteRegistrarTrait
{
    /**
     * Route Registrar instance
     *
     * @var Registrar|null
     */
    protected Registrar|null $routeRegistrar = null;

    /**
     * Set route registrar
     *
     * @param Registrar|null $registrar Route Registrar instance
     *
     * @return self
     */
    public function setRouteRegistrar(Registrar|null $registrar): static
    {
        $this->routeRegistrar = $registrar;

        return $this;
    }

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
    public function getRouteRegistrar(): Registrar|null
    {
        if (!$this->hasRouteRegistrar()) {
            $this->setRouteRegistrar($this->getDefaultRouteRegistrar());
        }
        return $this->routeRegistrar;
    }

    /**
     * Check if route registrar has been set
     *
     * @return bool True if route registrar has been set, false if not
     */
    public function hasRouteRegistrar(): bool
    {
        return isset($this->routeRegistrar);
    }

    /**
     * Get a default route registrar value, if any is available
     *
     * @return Registrar|null A default route registrar value or Null if no default value is available
     */
    public function getDefaultRouteRegistrar(): Registrar|null
    {
        return Route::getFacadeRoot();
    }
}
