<?php

namespace Aedart\Tests\Helpers\Dummies\Contracts;

/**
 * Name Aware
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Contracts
 */
interface NameAware
{
    /**
     * Set name
     *
     * @param string|null $name Name
     *
     * @return self
     */
    public function setName(?string $name);

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
    public function getName(): ?string;

    /**
     * Check if name has been set
     *
     * @return bool True if name has been set, false if not
     */
    public function hasName(): bool;

    /**
     * Get a default name value, if any is available
     *
     * @return string|null A default name value or Null if no default value is available
     */
    public function getDefaultName(): ?string;
}
