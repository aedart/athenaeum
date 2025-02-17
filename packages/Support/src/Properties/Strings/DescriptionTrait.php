<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Description Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\DescriptionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait DescriptionTrait
{
    /**
     * Description
     *
     * @var string|null
     */
    protected string|null $description = null;

    /**
     * Set description
     *
     * @param string|null $description Description
     *
     * @return self
     */
    public function setDescription(string|null $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * If no description value set, method
     * sets and returns a default description.
     *
     * @see getDefaultDescription()
     *
     * @return string|null description or null if no description has been set
     */
    public function getDescription(): string|null
    {
        if (!$this->hasDescription()) {
            $this->setDescription($this->getDefaultDescription());
        }
        return $this->description;
    }

    /**
     * Check if description has been set
     *
     * @return bool True if description has been set, false if not
     */
    public function hasDescription(): bool
    {
        return isset($this->description);
    }

    /**
     * Get a default description value, if any is available
     *
     * @return string|null Default description value or null if no default value is available
     */
    public function getDefaultDescription(): string|null
    {
        return null;
    }
}
