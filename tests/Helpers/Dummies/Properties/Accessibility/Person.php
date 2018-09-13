<?php

namespace Aedart\Tests\Helpers\Dummies\Properties\Accessibility;

use Aedart\Properties\Accessibility;

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
    use Accessibility;

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
}
