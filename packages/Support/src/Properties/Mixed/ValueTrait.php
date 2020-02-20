<?php

namespace Aedart\Support\Properties\Mixed;

/**
 * @deprecated Since v4.0, please use \Aedart\Support\Properties\Mixes\ValueTrait instead
 *
 * Value Trait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixed
 */
trait ValueTrait
{
    /**
     * Value
     *
     * @var mixed|null
     */
    protected $value = null;

    /**
     * Set value
     *
     * @param mixed|null $value Value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * If no "value" value set, method
     * sets and returns a default "value".
     *
     * @see getDefaultValue()
     *
     * @return mixed|null value or null if no value has been set
     */
    public function getValue()
    {
        if (!$this->hasValue()) {
            $this->setValue($this->getDefaultValue());
        }
        return $this->value;
    }

    /**
     * Check if "value" has been set
     *
     * @return bool True if "value" has been set, false if not
     */
    public function hasValue(): bool
    {
        return isset($this->value);
    }

    /**
     * Get a default "value" value, if any is available
     *
     * @return mixed|null Default "value" value or null if no default value is available
     */
    public function getDefaultValue()
    {
        return null;
    }
}
