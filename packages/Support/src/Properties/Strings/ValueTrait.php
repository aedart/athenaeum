<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Value Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ValueAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ValueTrait
{
    /**
     * Value
     *
     * @var string|null
     */
    protected string|null $value = null;

    /**
     * Set value
     *
     * @param string|null $value Value
     *
     * @return self
     */
    public function setValue(string|null $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * If no value value set, method
     * sets and returns a default value.
     *
     * @see getDefaultValue()
     *
     * @return string|null value or null if no value has been set
     */
    public function getValue(): string|null
    {
        if (!$this->hasValue()) {
            $this->setValue($this->getDefaultValue());
        }
        return $this->value;
    }

    /**
     * Check if value has been set
     *
     * @return bool True if value has been set, false if not
     */
    public function hasValue(): bool
    {
        return isset($this->value);
    }

    /**
     * Get a default value value, if any is available
     *
     * @return string|null Default value value or null if no default value is available
     */
    public function getDefaultValue(): string|null
    {
        return null;
    }
}
