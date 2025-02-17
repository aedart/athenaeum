<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Json Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\JsonAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait JsonTrait
{
    /**
     * JavaScript Object Notation (JSON)
     *
     * @var string|null
     */
    protected string|null $json = null;

    /**
     * Set json
     *
     * @param string|null $json JavaScript Object Notation (JSON)
     *
     * @return self
     */
    public function setJson(string|null $json): static
    {
        $this->json = $json;

        return $this;
    }

    /**
     * Get json
     *
     * If no json value set, method
     * sets and returns a default json.
     *
     * @see getDefaultJson()
     *
     * @return string|null json or null if no json has been set
     */
    public function getJson(): string|null
    {
        if (!$this->hasJson()) {
            $this->setJson($this->getDefaultJson());
        }
        return $this->json;
    }

    /**
     * Check if json has been set
     *
     * @return bool True if json has been set, false if not
     */
    public function hasJson(): bool
    {
        return isset($this->json);
    }

    /**
     * Get a default json value, if any is available
     *
     * @return string|null Default json value or null if no default value is available
     */
    public function getDefaultJson(): string|null
    {
        return null;
    }
}
