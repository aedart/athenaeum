<?php

namespace Aedart\Http\Api\Traits;

use Aedart\Contracts\Http\Api\Registrar;
use Aedart\Support\Facades\IoCFacade;

/**
 * Api Resource Registrar Trait
 *
 * @see \Aedart\Contracts\Http\Api\ApiResourceRegistrarAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Traits
 */
trait ApiResourceRegistrarTrait
{
    /**
     * Api Resource Registrar instance
     *
     * @var Registrar|null
     */
    protected Registrar|null $apiResourceRegistrar = null;

    /**
     * Set api resource registrar
     *
     * @param  Registrar|null  $registrar  Api Resource Registrar instance
     *
     * @return self
     */
    public function setApiResourceRegistrar(Registrar|null $registrar): static
    {
        $this->apiResourceRegistrar = $registrar;

        return $this;
    }

    /**
     * Get api resource registrar
     *
     * If no api resource registrar has been set, this method will
     * set and return a default api resource registrar, if any such
     * value is available
     *
     * @return Registrar|null api resource registrar or null if none api resource registrar has been set
     */
    public function getApiResourceRegistrar(): Registrar|null
    {
        if (!$this->hasApiResourceRegistrar()) {
            $this->setApiResourceRegistrar($this->getDefaultApiResourceRegistrar());
        }
        return $this->apiResourceRegistrar;
    }

    /**
     * Check if api resource registrar has been set
     *
     * @return bool True if api resource registrar has been set, false if not
     */
    public function hasApiResourceRegistrar(): bool
    {
        return isset($this->apiResourceRegistrar);
    }

    /**
     * Get a default api resource registrar value, if any is available
     *
     * @return Registrar|null A default api resource registrar value or Null if no default value is available
     */
    public function getDefaultApiResourceRegistrar(): Registrar|null
    {
        return IoCFacade::tryMake(Registrar::class);
    }
}
