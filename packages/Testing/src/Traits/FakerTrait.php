<?php

namespace Aedart\Testing\Traits;

use Faker\Factory;
use Faker\Generator;

/**
 * Faker Trait
 *
 * @see \Aedart\Contracts\Testing\Fakers\FakerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Traits
 */
trait FakerTrait
{
    /**
     * Faker Generator
     *
     * @var Generator|null
     */
    protected ?Generator $faker = null;

    /**
     * Set faker
     *
     * @param Generator|null $generator Faker Generator
     *
     * @return self
     */
    public function setFaker(?Generator $generator)
    {
        $this->faker = $generator;

        return $this;
    }

    /**
     * Get faker
     *
     * If no faker has been set, this method will
     * set and return a default faker, if any such
     * value is available
     *
     * @return Generator|null faker or null if none faker has been set
     */
    public function getFaker(): ?Generator
    {
        if (!$this->hasFaker()) {
            $this->setFaker($this->getDefaultFaker());
        }
        return $this->faker;
    }

    /**
     * Check if faker has been set
     *
     * @return bool True if faker has been set, false if not
     */
    public function hasFaker(): bool
    {
        return isset($this->faker);
    }

    /**
     * Get a default faker value, if any is available
     *
     * @return Generator|null A default faker value or Null if no default value is available
     */
    public function getDefaultFaker(): ?Generator
    {
        return Factory::create();
    }
}
