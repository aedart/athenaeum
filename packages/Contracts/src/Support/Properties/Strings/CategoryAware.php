<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Category Aware
 *
 * Component is aware of string "category"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface CategoryAware
{
    /**
     * Set category
     *
     * @param string|null $name Name of category
     *
     * @return self
     */
    public function setCategory(string|null $name): static;

    /**
     * Get category
     *
     * If no category value set, method
     * sets and returns a default category.
     *
     * @see getDefaultCategory()
     *
     * @return string|null category or null if no category has been set
     */
    public function getCategory(): string|null;

    /**
     * Check if category has been set
     *
     * @return bool True if category has been set, false if not
     */
    public function hasCategory(): bool;

    /**
     * Get a default category value, if any is available
     *
     * @return string|null Default category value or null if no default value is available
     */
    public function getDefaultCategory(): string|null;
}
