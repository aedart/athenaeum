<?php

namespace Aedart\Contracts\Support\Properties\Arrays;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Choices Aware
 *
 * Component is aware of array "choices"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Arrays
 */
interface ChoicesAware
{
    /**
     * Set choices
     *
     * @param array|null $list Various choices that can be made
     *
     * @return self
     */
    public function setChoices(array|null $list): static;

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
    public function getChoices(): array|null;

    /**
     * Check if choices has been set
     *
     * @return bool True if choices has been set, false if not
     */
    public function hasChoices(): bool;

    /**
     * Get a default choices value, if any is available
     *
     * @return array|null Default choices value or null if no default value is available
     */
    public function getDefaultChoices(): array|null;
}
