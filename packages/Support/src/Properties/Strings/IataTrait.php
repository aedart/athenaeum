<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Iata Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IataAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IataTrait
{
    /**
     * International Air Transport Association code
     *
     * @var string|null
     */
    protected string|null $iata = null;

    /**
     * Set iata
     *
     * @param string|null $code International Air Transport Association code
     *
     * @return self
     */
    public function setIata(string|null $code): static
    {
        $this->iata = $code;

        return $this;
    }

    /**
     * Get iata
     *
     * If no iata value set, method
     * sets and returns a default iata.
     *
     * @see getDefaultIata()
     *
     * @return string|null iata or null if no iata has been set
     */
    public function getIata(): string|null
    {
        if (!$this->hasIata()) {
            $this->setIata($this->getDefaultIata());
        }
        return $this->iata;
    }

    /**
     * Check if iata has been set
     *
     * @return bool True if iata has been set, false if not
     */
    public function hasIata(): bool
    {
        return isset($this->iata);
    }

    /**
     * Get a default iata value, if any is available
     *
     * @return string|null Default iata value or null if no default value is available
     */
    public function getDefaultIata(): string|null
    {
        return null;
    }
}
