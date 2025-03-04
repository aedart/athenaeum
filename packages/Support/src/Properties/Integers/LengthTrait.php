<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Length Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\LengthAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait LengthTrait
{
    /**
     * Length of something
     *
     * @var int|null
     */
    protected int|null $length = null;

    /**
     * Set length
     *
     * @param int|null $amount Length of something
     *
     * @return self
     */
    public function setLength(int|null $amount): static
    {
        $this->length = $amount;

        return $this;
    }

    /**
     * Get length
     *
     * If no length value set, method
     * sets and returns a default length.
     *
     * @see getDefaultLength()
     *
     * @return int|null length or null if no length has been set
     */
    public function getLength(): int|null
    {
        if (!$this->hasLength()) {
            $this->setLength($this->getDefaultLength());
        }
        return $this->length;
    }

    /**
     * Check if length has been set
     *
     * @return bool True if length has been set, false if not
     */
    public function hasLength(): bool
    {
        return isset($this->length);
    }

    /**
     * Get a default length value, if any is available
     *
     * @return int|null Default length value or null if no default value is available
     */
    public function getDefaultLength(): int|null
    {
        return null;
    }
}
