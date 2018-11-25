<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Category Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CategoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CategoryTrait
{
    /**
     * Name of category
     *
     * @var string|null
     */
    protected $category = null;

    /**
     * Set category
     *
     * @param string|null $name Name of category
     *
     * @return self
     */
    public function setCategory(?string $name)
    {
        $this->category = $name;

        return $this;
    }

    /**
     * Get category
     *
     * If no "category" value set, method
     * sets and returns a default "category".
     *
     * @see getDefaultCategory()
     *
     * @return string|null category or null if no category has been set
     */
    public function getCategory() : ?string
    {
        if ( ! $this->hasCategory()) {
            $this->setCategory($this->getDefaultCategory());
        }
        return $this->category;
    }

    /**
     * Check if "category" has been set
     *
     * @return bool True if "category" has been set, false if not
     */
    public function hasCategory() : bool
    {
        return isset($this->category);
    }

    /**
     * Get a default "category" value, if any is available
     *
     * @return string|null Default "category" value or null if no default value is available
     */
    public function getDefaultCategory() : ?string
    {
        return null;
    }
}
