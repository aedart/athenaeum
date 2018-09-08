<?php

namespace Aedart\Tests\Helpers\Dummies\Contracts;

/**
 * Age Aware
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Contracts
 */
interface AgeAware
{
    /**
     * Set age
     *
     * @param int|null $age Age
     *
     * @return self
     */
    public function setAge(?int $age);

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
    public function getAge(): ?int;

    /**
     * Check if age has been set
     *
     * @return bool True if age has been set, false if not
     */
    public function hasAge(): bool;

    /**
     * Get a default age value, if any is available
     *
     * @return int|null A default age value or Null if no default value is available
     */
    public function getDefaultAge(): ?int;
}
