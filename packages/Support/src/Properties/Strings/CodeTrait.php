<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Code Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\CodeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait CodeTrait
{
    /**
     * The code for something, e.g. language code, classification code, or perhaps an artifacts identifier
     *
     * @var string|null
     */
    protected string|null $code = null;

    /**
     * Set code
     *
     * @param string|null $code The code for something, e.g. language code, classification code, or perhaps an artifacts identifier
     *
     * @return self
     */
    public function setCode(string|null $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * If no code value set, method
     * sets and returns a default code.
     *
     * @see getDefaultCode()
     *
     * @return string|null code or null if no code has been set
     */
    public function getCode(): string|null
    {
        if (!$this->hasCode()) {
            $this->setCode($this->getDefaultCode());
        }
        return $this->code;
    }

    /**
     * Check if code has been set
     *
     * @return bool True if code has been set, false if not
     */
    public function hasCode(): bool
    {
        return isset($this->code);
    }

    /**
     * Get a default code value, if any is available
     *
     * @return string|null Default code value or null if no default value is available
     */
    public function getDefaultCode(): string|null
    {
        return null;
    }
}
