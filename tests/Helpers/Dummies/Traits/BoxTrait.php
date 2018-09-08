<?php

namespace Aedart\Tests\Helpers\Dummies\Traits;


use Aedart\Tests\Helpers\Dummies\Contracts\Box;
use Aedart\Tests\Helpers\Dummies\Contracts\BoxAware;

/**
 * Box Trait
 *
 * FOR TESTING ONLY
 *
 * @see \Aedart\Tests\Helpers\Dummies\Contracts\BoxAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Traits
 */
trait BoxTrait
{
    /**
     * Box instance
     *
     * @var Box|null
     */
    protected $box = null;

    /**
     * Set box
     *
     * @param Box|null $box Box instance
     *
     * @return self
     */
    public function setBox(?Box $box)
    {
        $this->box = $box;

        return $this;
    }

    /**
     * Get box
     *
     * If no box has been set, this method will
     * set and return a default box, if any such
     * value is available
     *
     * @see getDefaultBox()
     *
     * @return Box|null box or null if none box has been set
     */
    public function getBox(): ?Box
    {
        if (!$this->hasBox()) {
            $this->setBox($this->getDefaultBox());
        }
        return $this->box;
    }

    /**
     * Check if box has been set
     *
     * @return bool True if box has been set, false if not
     */
    public function hasBox(): bool
    {
        return isset($this->box);
    }

    /**
     * Get a default box value, if any is available
     *
     * @return Box|null A default box value or Null if no default value is available
     */
    public function getDefaultBox(): ?Box
    {
        return null;
    }
}
