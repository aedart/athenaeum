<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Author Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\AuthorAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait AuthorTrait
{
    /**
     * Name of author
     *
     * @var string|null
     */
    protected string|null $author = null;

    /**
     * Set author
     *
     * @param string|null $name Name of author
     *
     * @return self
     */
    public function setAuthor(string|null $name): static
    {
        $this->author = $name;

        return $this;
    }

    /**
     * Get author
     *
     * If no author value set, method
     * sets and returns a default author.
     *
     * @see getDefaultAuthor()
     *
     * @return string|null author or null if no author has been set
     */
    public function getAuthor(): string|null
    {
        if (!$this->hasAuthor()) {
            $this->setAuthor($this->getDefaultAuthor());
        }
        return $this->author;
    }

    /**
     * Check if author has been set
     *
     * @return bool True if author has been set, false if not
     */
    public function hasAuthor(): bool
    {
        return isset($this->author);
    }

    /**
     * Get a default author value, if any is available
     *
     * @return string|null Default author value or null if no default value is available
     */
    public function getDefaultAuthor(): string|null
    {
        return null;
    }
}
