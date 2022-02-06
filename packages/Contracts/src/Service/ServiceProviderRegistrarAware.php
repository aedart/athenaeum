<?php

namespace Aedart\Contracts\Service;

/**
 * Service Provider Registrar Aware
 *
 * @see \Aedart\Contracts\Service\Registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Service
 */
interface ServiceProviderRegistrarAware
{
    /**
     * Set service provider registrar
     *
     * @param Registrar|null $registrar Service Provider Registrar instance
     *
     * @return self
     */
    public function setServiceProviderRegistrar(Registrar|null $registrar): static;

    /**
     * Get service provider registrar
     *
     * If no service provider registrar has been set, this method will
     * set and return a default service provider registrar, if any such
     * value is available
     *
     * @return Registrar|null service provider registrar or null if none service provider registrar has been set
     */
    public function getServiceProviderRegistrar(): Registrar|null;

    /**
     * Check if service provider registrar has been set
     *
     * @return bool True if service provider registrar has been set, false if not
     */
    public function hasServiceProviderRegistrar(): bool;

    /**
     * Get a default service provider registrar value, if any is available
     *
     * @return Registrar|null A default service provider registrar value or Null if no default value is available
     */
    public function getDefaultServiceProviderRegistrar(): Registrar|null;
}
