<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Dto;

/**
 * Person
 *
 * FOR TESTING ONLY
 *
 * @property string $name
 * @property int $age
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
class Person extends Dto
{
    /**
     * Name of person
     *
     * @var string|null
     */
    protected $name = null;

    /**
     * Age of person
     *
     * @var int|null
     */
    protected $age = null;

    /**
     * Set name
     *
     * @param string|null $name Name of person
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
     * @return string|null name or null if none name has been set
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set age
     *
     * @param int|null $age Age of person
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
     * @return int|null age or null if none age has been set
     */
    public function getAge(): ?int
    {
        return $this->age;
    }
}
