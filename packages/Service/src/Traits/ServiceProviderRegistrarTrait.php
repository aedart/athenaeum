<?php

namespace Aedart\Service\Traits;

use Aedart\Contracts\Service\Registrar;
use Aedart\Support\Facades\IoCFacade;

/**
 * Service Provider Registrar Trait
 *
 * @see \Aedart\Contracts\Service\ServiceProviderRegistrarAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Service\Traits
 */
trait ServiceProviderRegistrarTrait
{
    /**
     * Service Provider Registrar instance
     *
     * @var Registrar|null
     */
    protected ?Registrar $serviceProviderRegistrar = null;

    /**
     * Set service provider registrar
     *
     * @param Registrar|null $registrar Service Provider Registrar instance
     *
     * @return self
     */
    public function setServiceProviderRegistrar(?Registrar $registrar)
    {
        $this->serviceProviderRegistrar = $registrar;

        return $this;
    }

    /**
     * Get service provider registrar
     *
     * If no service provider registrar has been set, this method will
     * set and return a default service provider registrar, if any such
     * value is available
     *
     * @return Registrar|null service provider registrar or null if none service provider registrar has been set
     */
    public function getServiceProviderRegistrar(): ?Registrar
    {
        if (!$this->hasServiceProviderRegistrar()) {
            $this->setServiceProviderRegistrar($this->getDefaultServiceProviderRegistrar());
        }
        return $this->serviceProviderRegistrar;
    }

    /**
     * Check if service provider registrar has been set
     *
     * @return bool True if service provider registrar has been set, false if not
     */
    public function hasServiceProviderRegistrar(): bool
    {
        return isset($this->serviceProviderRegistrar);
    }

    /**
     * Get a default service provider registrar value, if any is available
     *
     * @return Registrar|null A default service provider registrar value or Null if no default value is available
     */
    public function getDefaultServiceProviderRegistrar(): ?Registrar
    {
        return IoCFacade::tryMake(Registrar::class);
    }
}
