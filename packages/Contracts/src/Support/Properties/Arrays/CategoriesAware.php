<?php

namespace Aedart\Contracts\Support\Properties\Arrays;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Categories Aware
 *
 * Component is aware of array "categories"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Arrays
 */
interface CategoriesAware
{
    /**
     * Set categories
     *
     * @param array|null $list List of category names
     *
     * @return self
     */
    public function setCategories(array|null $list): static;

    /**
     * Get categories
     *
     * If no categories value set, method
     * sets and returns a default categories.
     *
     * @see getDefaultCategories()
     *
     * @return array|null categories or null if no categories has been set
     */
    public function getCategories(): array|null;

    /**
     * Check if categories has been set
     *
     * @return bool True if categories has been set, false if not
     */
    public function hasCategories(): bool;

    /**
     * Get a default categories value, if any is available
     *
     * @return array|null Default categories value or null if no default value is available
     */
    public function getDefaultCategories(): array|null;
}
