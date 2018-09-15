<?php

namespace Aedart\Tests\Helpers\Dummies\Properties\Accessibility;

use Aedart\Properties\Overload;

/**
 * Person
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Properties\Accessibility
 */
class Person
{
    use Overload;

    /**
     * Name of person
     *
     * @var string
     */
    public $name = 'John Doe';

    /**
     * Age of person
     *
     * @var int
     */
    protected $age = 42;

    /**
     * Height of person
     *
     * @var int
     */
    private $height = 193;

    /**
     * N/A
     *
     * @return bool
     */
    protected function myInternalMethod() : bool
    {
        return false;
    }

    /**
     * Set name of this person
     *
     * @param null|string $value
     *
     * @return self
     */
    public function setName(?string $value)
    {
        $this->name = $value;

        return $this;
    }

    /**
     * Returns name of this person
     *
     * @return null|string
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /*****************************************************************
     * Utils
     ****************************************************************/

    /**
     * Determine if property isset
     *
     * @param string $propName
     *
     * @return bool
     */
    public function isPropSet(string $propName) : bool
    {
        return isset($this->$propName);
    }

    /**
     * Unset this person's name
     */
    public function unsetName()
    {
        unset($this->name);
    }
}
