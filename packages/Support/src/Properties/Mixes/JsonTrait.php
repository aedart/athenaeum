<?php

namespace Aedart\Support\Properties\Mixes;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Json Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Mixes\JsonAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Mixes
 */
trait JsonTrait
{
    /**
     * JavaScript Object Notation (JSON)
     *
     * @var mixed
     */
    protected $json = null;

    /**
     * Set json
     *
     * @param mixed $json JavaScript Object Notation (JSON)
     *
     * @return self
     */
    public function setJson(mixed $json): static
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
     * @return mixed json or null if no json has been set
     */
    public function getJson(): mixed
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
     * @return mixed Default json value or null if no default value is available
     */
    public function getDefaultJson(): mixed
    {
        return null;
    }
}
