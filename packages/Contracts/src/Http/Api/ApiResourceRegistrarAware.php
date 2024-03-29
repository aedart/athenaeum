<?php

namespace Aedart\Contracts\Http\Api;

/**
 * Api Resource Registrar Aware
 *
 * @see \Aedart\Contracts\Http\Api\Registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Api
 */
interface ApiResourceRegistrarAware
{
    /**
     * Set api resource registrar
     *
     * @param  Registrar|null  $registrar  Api Resource Registrar instance
     *
     * @return static
     */
    public function setApiResourceRegistrar(Registrar|null $registrar): static;

    /**
     * Get api resource registrar
     *
     * If no api resource registrar has been set, this method will
     * set and return a default api resource registrar, if any such
     * value is available
     *
     * @return Registrar|null api resource registrar or null if none api resource registrar has been set
     */
    public function getApiResourceRegistrar(): Registrar|null;

    /**
     * Check if api resource registrar has been set
     *
     * @return bool True if api resource registrar has been set, false if not
     */
    public function hasApiResourceRegistrar(): bool;

    /**
     * Get a default api resource registrar value, if any is available
     *
     * @return Registrar|null A default api resource registrar value or Null if no default value is available
     */
    public function getDefaultApiResourceRegistrar(): Registrar|null;
}
