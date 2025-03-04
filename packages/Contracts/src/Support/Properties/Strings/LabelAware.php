<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Label Aware
 *
 * Component is aware of string "label"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface LabelAware
{
    /**
     * Set label
     *
     * @param string|null $name Label name
     *
     * @return self
     */
    public function setLabel(string|null $name): static;

    /**
     * Get label
     *
     * If no label value set, method
     * sets and returns a default label.
     *
     * @see getDefaultLabel()
     *
     * @return string|null label or null if no label has been set
     */
    public function getLabel(): string|null;

    /**
     * Check if label has been set
     *
     * @return bool True if label has been set, false if not
     */
    public function hasLabel(): bool;

    /**
     * Get a default label value, if any is available
     *
     * @return string|null Default label value or null if no default value is available
     */
    public function getDefaultLabel(): string|null;
}
