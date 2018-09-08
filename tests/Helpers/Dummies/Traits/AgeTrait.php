<?php

namespace Aedart\Tests\Helpers\Dummies\Traits;

/**
 * Age Trait
 *
 * FOR TESTING ONLY
 *
 * @see \Aedart\Tests\Helpers\Dummies\Contracts\AgeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Traits
 */
trait AgeTrait
{
    /**
     * Age
     *
     * @var int|null
     */
    protected $age = null;

    /**
     * Set age
     *
     * @param int|null $age Age
     *
     * @return self
     */
    public function setAge(?int $age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * If no age has been set, this method will
     * set and return a default age, if any such
     * value is available
     *
     * @see getDefaultAge()
     *
     * @return int|null age or null if none age has been set
     */
    public function getAge(): ?int
    {
        if (!$this->hasAge()) {
            $this->setAge($this->getDefaultAge());
        }
        return $this->age;
    }

    /**
     * Check if age has been set
     *
     * @return bool True if age has been set, false if not
     */
    public function hasAge(): bool
    {
        return isset($this->age);
    }

    /**
     * Get a default age value, if any is available
     *
     * @return int|null A default age value or Null if no default value is available
     */
    public function getDefaultAge(): ?int
    {
        return null;
    }
}
