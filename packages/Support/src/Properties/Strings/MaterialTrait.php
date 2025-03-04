<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Material Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\MaterialAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait MaterialTrait
{
    /**
     * Name or identifier of a material, e.g. leather, wool, cotton, paper.
     *
     * @var string|null
     */
    protected string|null $material = null;

    /**
     * Set material
     *
     * @param string|null $identifier Name or identifier of a material, e.g. leather, wool, cotton, paper.
     *
     * @return self
     */
    public function setMaterial(string|null $identifier): static
    {
        $this->material = $identifier;

        return $this;
    }

    /**
     * Get material
     *
     * If no material value set, method
     * sets and returns a default material.
     *
     * @see getDefaultMaterial()
     *
     * @return string|null material or null if no material has been set
     */
    public function getMaterial(): string|null
    {
        if (!$this->hasMaterial()) {
            $this->setMaterial($this->getDefaultMaterial());
        }
        return $this->material;
    }

    /**
     * Check if material has been set
     *
     * @return bool True if material has been set, false if not
     */
    public function hasMaterial(): bool
    {
        return isset($this->material);
    }

    /**
     * Get a default material value, if any is available
     *
     * @return string|null Default material value or null if no default value is available
     */
    public function getDefaultMaterial(): string|null
    {
        return null;
    }
}
