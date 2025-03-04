<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Isbn Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\IsbnAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait IsbnTrait
{
    /**
     * International Standard Book Number (ISBN)
     *
     * @var string|null
     */
    protected string|null $isbn = null;

    /**
     * Set isbn
     *
     * @param string|null $isbn International Standard Book Number (ISBN)
     *
     * @return self
     */
    public function setIsbn(string|null $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * If no isbn value set, method
     * sets and returns a default isbn.
     *
     * @see getDefaultIsbn()
     *
     * @return string|null isbn or null if no isbn has been set
     */
    public function getIsbn(): string|null
    {
        if (!$this->hasIsbn()) {
            $this->setIsbn($this->getDefaultIsbn());
        }
        return $this->isbn;
    }

    /**
     * Check if isbn has been set
     *
     * @return bool True if isbn has been set, false if not
     */
    public function hasIsbn(): bool
    {
        return isset($this->isbn);
    }

    /**
     * Get a default isbn value, if any is available
     *
     * @return string|null Default isbn value or null if no default value is available
     */
    public function getDefaultIsbn(): string|null
    {
        return null;
    }
}
