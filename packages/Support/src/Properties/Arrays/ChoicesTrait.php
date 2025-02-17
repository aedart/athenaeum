<?php

namespace Aedart\Support\Properties\Arrays;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Choices Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Arrays\ChoicesAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Arrays
 */
trait ChoicesTrait
{
    /**
     * Various choices that can be made
     *
     * @var array|null
     */
    protected array|null $choices = null;

    /**
     * Set choices
     *
     * @param array|null $list Various choices that can be made
     *
     * @return self
     */
    public function setChoices(array|null $list): static
    {
        $this->choices = $list;

        return $this;
    }

    /**
     * Get choices
     *
     * If no choices value set, method
     * sets and returns a default choices.
     *
     * @see getDefaultChoices()
     *
     * @return array|null choices or null if no choices has been set
     */
    public function getChoices(): array|null
    {
        if (!$this->hasChoices()) {
            $this->setChoices($this->getDefaultChoices());
        }
        return $this->choices;
    }

    /**
     * Check if choices has been set
     *
     * @return bool True if choices has been set, false if not
     */
    public function hasChoices(): bool
    {
        return isset($this->choices);
    }

    /**
     * Get a default choices value, if any is available
     *
     * @return array|null Default choices value or null if no default value is available
     */
    public function getDefaultChoices(): array|null
    {
        return null;
    }
}
