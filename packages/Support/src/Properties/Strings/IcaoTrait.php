<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Icao Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IcaoAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IcaoTrait
{
    /**
     * International Civil Aviation Organization code
     *
     * @var string|null
     */
    protected string|null $icao = null;

    /**
     * Set icao
     *
     * @param string|null $code International Civil Aviation Organization code
     *
     * @return self
     */
    public function setIcao(string|null $code): static
    {
        $this->icao = $code;

        return $this;
    }

    /**
     * Get icao
     *
     * If no icao value set, method
     * sets and returns a default icao.
     *
     * @see getDefaultIcao()
     *
     * @return string|null icao or null if no icao has been set
     */
    public function getIcao(): string|null
    {
        if (!$this->hasIcao()) {
            $this->setIcao($this->getDefaultIcao());
        }
        return $this->icao;
    }

    /**
     * Check if icao has been set
     *
     * @return bool True if icao has been set, false if not
     */
    public function hasIcao(): bool
    {
        return isset($this->icao);
    }

    /**
     * Get a default icao value, if any is available
     *
     * @return string|null Default icao value or null if no default value is available
     */
    public function getDefaultIcao(): string|null
    {
        return null;
    }
}
