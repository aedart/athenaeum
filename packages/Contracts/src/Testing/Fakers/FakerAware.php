<?php

namespace Aedart\Contracts\Testing\Fakers;

use Faker\Generator;

/**
 * Faker Aware
 *
 * @see \Faker\Generator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Testing\Fakers
 */
interface FakerAware
{
    /**
     * Set faker
     *
     * @param Generator|null $generator Faker Generator
     *
     * @return self
     */
    public function setFaker(Generator|null $generator): static;

    /**
     * Get faker
     *
     * If no faker has been set, this method will
     * set and return a default faker, if any such
     * value is available
     *
     * @return Generator|null faker or null if none faker has been set
     */
    public function getFaker(): Generator|null;

    /**
     * Check if faker has been set
     *
     * @return bool True if faker has been set, false if not
     */
    public function hasFaker(): bool;

    /**
     * Get a default faker value, if any is available
     *
     * @return Generator|null A default faker value or Null if no default value is available
     */
    public function getDefaultFaker(): Generator|null;
}
