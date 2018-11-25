<?php

namespace Aedart\Support\Properties\Floats;

/**
 * Height Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Floats\HeightAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Floats
 */
trait HeightTrait
{
    /**
     * Height of something
     *
     * @var float|null
     */
    protected $height = null;

    /**
     * Set height
     *
     * @param float|null $amount Height of something
     *
     * @return self
     */
    public function setHeight(?float $amount)
    {
        $this->height = $amount;

        return $this;
    }

    /**
     * Get height
     *
     * If no "height" value set, method
     * sets and returns a default "height".
     *
     * @see getDefaultHeight()
     *
     * @return float|null height or null if no height has been set
     */
    public function getHeight() : ?float
    {
        if ( ! $this->hasHeight()) {
            $this->setHeight($this->getDefaultHeight());
        }
        return $this->height;
    }

    /**
     * Check if "height" has been set
     *
     * @return bool True if "height" has been set, false if not
     */
    public function hasHeight() : bool
    {
        return isset($this->height);
    }

    /**
     * Get a default "height" value, if any is available
     *
     * @return float|null Default "height" value or null if no default value is available
     */
    public function getDefaultHeight() : ?float
    {
        return null;
    }
}
