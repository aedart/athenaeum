<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Swift Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\SwiftAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait SwiftTrait
{
    /**
     * ISO-9362 Swift Code
     *
     * @var string|null
     */
    protected string|null $swift = null;

    /**
     * Set swift
     *
     * @param string|null $code ISO-9362 Swift Code
     *
     * @return self
     */
    public function setSwift(string|null $code): static
    {
        $this->swift = $code;

        return $this;
    }

    /**
     * Get swift
     *
     * If no swift value set, method
     * sets and returns a default swift.
     *
     * @see getDefaultSwift()
     *
     * @return string|null swift or null if no swift has been set
     */
    public function getSwift(): string|null
    {
        if (!$this->hasSwift()) {
            $this->setSwift($this->getDefaultSwift());
        }
        return $this->swift;
    }

    /**
     * Check if swift has been set
     *
     * @return bool True if swift has been set, false if not
     */
    public function hasSwift(): bool
    {
        return isset($this->swift);
    }

    /**
     * Get a default swift value, if any is available
     *
     * @return string|null Default swift value or null if no default value is available
     */
    public function getDefaultSwift(): string|null
    {
        return null;
    }
}
