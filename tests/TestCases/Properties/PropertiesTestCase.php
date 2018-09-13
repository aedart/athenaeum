<?php

namespace Aedart\Tests\TestCases\Properties;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Properties\Accessibility\Person;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Properties Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Properties
 */
abstract class PropertiesTestCase extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a new dummy with accessibility
     *
     * @return Person
     */
    public function makeDummy()
    {
        return new Person();
    }

    /**
     * Get a method - with its accessibility set to true
     *
     * @param string $name Method name
     * @return ReflectionMethod
     */

    /**
     * Returns a method with it's accessibility set to true (forced)
     *
     * @param string $name Method name
     *
     * @return ReflectionMethod
     *
     * @throws ReflectionException
     */
    public function getMethod(string $name) : ReflectionMethod
    {
        $class = new ReflectionClass($this->makeDummy());
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
