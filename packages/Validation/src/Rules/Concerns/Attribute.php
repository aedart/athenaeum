<?php

namespace Aedart\Validation\Rules\Concerns;

/**
 * Concerns Attribute
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Validation\Rules\Concerns
 */
trait Attribute
{
    /**
     * Name of the attribute in question
     *
     * @var string|null
     */
    protected string|null $attribute = null;

    /**
     * Set name of the attribute that is being validated
     *
     * @param string|null $attribute
     *
     * @return self
     */
    public function setAttribute(string|null $attribute): static
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get name of the attribute that is being validated
     *
     * @return string|null
     */
    public function getAttribute(): string|null
    {
        return $this->attribute;
    }

    /**
     * Determine if attribute name has been set
     *
     * @return bool
     */
    public function hasAttribute(): bool
    {
        return isset($this->attribute);
    }
}
