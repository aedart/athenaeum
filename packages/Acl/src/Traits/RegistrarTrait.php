<?php

namespace Aedart\Acl\Traits;

use Aedart\Contracts\Acl\Registrar;
use Aedart\Support\Facades\IoCFacade;

/**
 * Registrar Trait
 *
 * @see \Aedart\Contracts\Acl\RegistrarAware
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Traits
 */
trait RegistrarTrait
{
    /**
     * Acl Registrar instance
     *
     * @var Registrar|null
     */
    protected ?Registrar $registrar = null;

    /**
     * Set registrar
     *
     * @param Registrar|null $registrar Acl Registrar instance
     *
     * @return self
     */
    public function setRegistrar(?Registrar $registrar)
    {
        $this->registrar = $registrar;

        return $this;
    }

    /**
     * Get registrar
     *
     * If no registrar has been set, this method will
     * set and return a default registrar, if any such
     * value is available
     *
     * @return Registrar|null registrar or null if none registrar has been set
     */
    public function getRegistrar(): ?Registrar
    {
        if (!$this->hasRegistrar()) {
            $this->setRegistrar($this->getDefaultRegistrar());
        }
        return $this->registrar;
    }

    /**
     * Check if registrar has been set
     *
     * @return bool True if registrar has been set, false if not
     */
    public function hasRegistrar(): bool
    {
        return isset($this->registrar);
    }

    /**
     * Get a default registrar value, if any is available
     *
     * @return Registrar|null A default registrar value or Null if no default value is available
     */
    public function getDefaultRegistrar(): ?Registrar
    {
        return IoCFacade::tryMake(Registrar::class);
    }
}