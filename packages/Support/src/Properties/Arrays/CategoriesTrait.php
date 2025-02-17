<?php

namespace Aedart\Support\Properties\Arrays;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Categories Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Arrays\CategoriesAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Arrays
 */
trait CategoriesTrait
{
    /**
     * List of category names
     *
     * @var array|null
     */
    protected array|null $categories = null;

    /**
     * Set categories
     *
     * @param array|null $list List of category names
     *
     * @return self
     */
    public function setCategories(array|null $list): static
    {
        $this->categories = $list;

        return $this;
    }

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
    public function getCategories(): array|null
    {
        if (!$this->hasCategories()) {
            $this->setCategories($this->getDefaultCategories());
        }
        return $this->categories;
    }

    /**
     * Check if categories has been set
     *
     * @return bool True if categories has been set, false if not
     */
    public function hasCategories(): bool
    {
        return isset($this->categories);
    }

    /**
     * Get a default categories value, if any is available
     *
     * @return array|null Default categories value or null if no default value is available
     */
    public function getDefaultCategories(): array|null
    {
        return null;
    }
}
