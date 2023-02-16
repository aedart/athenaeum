<?php

namespace Aedart\Contracts\Acl;

/**
 * Registrar Aware
 *
 * @see Registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Acl
 */
interface RegistrarAware
{
    /**
     * Set registrar
     *
     * @param Registrar|null $registrar Acl Registrar instance
     *
     * @return self
     */
    public function setRegistrar(Registrar|null $registrar): static;

    /**
     * Get registrar
     *
     * If no registrar has been set, this method will
     * set and return a default registrar, if any such
     * value is available
     *
     * @return Registrar|null registrar or null if none registrar has been set
     */
    public function getRegistrar(): Registrar|null;

    /**
     * Check if registrar has been set
     *
     * @return bool True if registrar has been set, false if not
     */
    public function hasRegistrar(): bool;

    /**
     * Get a default registrar value, if any is available
     *
     * @return Registrar|null A default registrar value or Null if no default value is available
     */
    public function getDefaultRegistrar(): Registrar|null;
}
