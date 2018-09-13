<?php

namespace Aedart\Tests\Helpers\Dummies\Properties\Accessibility;

use Aedart\Properties\Reflections;

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
    use Reflections;

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
}
