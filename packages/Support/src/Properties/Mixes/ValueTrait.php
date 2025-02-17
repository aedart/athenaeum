<?php

namespace Aedart\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Value Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Mixes\ValueAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixes
 */
trait ValueTrait
{
    /**
     * Value
     *
     * @var mixed
     */
    protected $value = null;

    /**
     * Set value
     *
     * @param mixed $value Value
     *
     * @return self
     */
    public function setValue(mixed $value): static
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
     * @return mixed value or null if no value has been set
     */
    public function getValue(): mixed
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
     * @return mixed Default value value or null if no default value is available
     */
    public function getDefaultValue(): mixed
    {
        return null;
    }
}
