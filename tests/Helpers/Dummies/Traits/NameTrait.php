<?php

namespace Aedart\Tests\Helpers\Dummies\Traits;

/**
 * Name Trait
 *
 * FOR TESTING ONLY
 *
 * @see \Aedart\Tests\Helpers\Dummies\Contracts\NameAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Traits
 */
trait NameTrait
{
    /**
     * Name
     *
     * @var string|null
     */
    protected $name = null;

    /**
     * Set name
     *
     * @param string|null $name Name
     *
     * @return self
     */
    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * If no name has been set, this method will
     * set and return a default name, if any such
     * value is available
     *
     * @see getDefaultName()
     *
     * @return string|null name or null if none name has been set
     */
    public function getName(): ?string
    {
        if (!$this->hasName()) {
            $this->setName($this->getDefaultName());
        }
        return $this->name;
    }

    /**
     * Check if name has been set
     *
     * @return bool True if name has been set, false if not
     */
    public function hasName(): bool
    {
        return isset($this->name);
    }

    /**
     * Get a default name value, if any is available
     *
     * @return string|null A default name value or Null if no default value is available
     */
    public function getDefaultName(): ?string
    {
        return null;
    }
}
