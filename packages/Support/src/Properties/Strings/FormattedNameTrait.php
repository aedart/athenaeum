<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Formatted name Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\FormattedNameAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait FormattedNameTrait
{
    /**
     * Formatted name of someone or something
     *
     * @var string|null
     */
    protected string|null $formattedName = null;

    /**
     * Set formatted name
     *
     * @param string|null $name Formatted name of someone or something
     *
     * @return self
     */
    public function setFormattedName(string|null $name): static
    {
        $this->formattedName = $name;

        return $this;
    }

    /**
     * Get formatted name
     *
     * If no formatted name value set, method
     * sets and returns a default formatted name.
     *
     * @see getDefaultFormattedName()
     *
     * @return string|null formatted name or null if no formatted name has been set
     */
    public function getFormattedName(): string|null
    {
        if (!$this->hasFormattedName()) {
            $this->setFormattedName($this->getDefaultFormattedName());
        }
        return $this->formattedName;
    }

    /**
     * Check if formatted name has been set
     *
     * @return bool True if formatted name has been set, false if not
     */
    public function hasFormattedName(): bool
    {
        return isset($this->formattedName);
    }

    /**
     * Get a default formatted name value, if any is available
     *
     * @return string|null Default formatted name value or null if no default value is available
     */
    public function getDefaultFormattedName(): string|null
    {
        return null;
    }
}
