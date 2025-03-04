<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Info Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\InfoAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait InfoTrait
{
    /**
     * Information about someone or something
     *
     * @var string|null
     */
    protected string|null $info = null;

    /**
     * Set info
     *
     * @param string|null $text Information about someone or something
     *
     * @return self
     */
    public function setInfo(string|null $text): static
    {
        $this->info = $text;

        return $this;
    }

    /**
     * Get info
     *
     * If no info value set, method
     * sets and returns a default info.
     *
     * @see getDefaultInfo()
     *
     * @return string|null info or null if no info has been set
     */
    public function getInfo(): string|null
    {
        if (!$this->hasInfo()) {
            $this->setInfo($this->getDefaultInfo());
        }
        return $this->info;
    }

    /**
     * Check if info has been set
     *
     * @return bool True if info has been set, false if not
     */
    public function hasInfo(): bool
    {
        return isset($this->info);
    }

    /**
     * Get a default info value, if any is available
     *
     * @return string|null Default info value or null if no default value is available
     */
    public function getDefaultInfo(): string|null
    {
        return null;
    }
}
