<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Error Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ErrorAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ErrorTrait
{
    /**
     * Error name or identifier
     *
     * @var string|null
     */
    protected string|null $error = null;

    /**
     * Set error
     *
     * @param string|null $identifier Error name or identifier
     *
     * @return self
     */
    public function setError(string|null $identifier): static
    {
        $this->error = $identifier;

        return $this;
    }

    /**
     * Get error
     *
     * If no error value set, method
     * sets and returns a default error.
     *
     * @see getDefaultError()
     *
     * @return string|null error or null if no error has been set
     */
    public function getError(): string|null
    {
        if (!$this->hasError()) {
            $this->setError($this->getDefaultError());
        }
        return $this->error;
    }

    /**
     * Check if error has been set
     *
     * @return bool True if error has been set, false if not
     */
    public function hasError(): bool
    {
        return isset($this->error);
    }

    /**
     * Get a default error value, if any is available
     *
     * @return string|null Default error value or null if no default value is available
     */
    public function getDefaultError(): string|null
    {
        return null;
    }
}
