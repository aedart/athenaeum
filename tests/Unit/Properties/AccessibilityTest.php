<?php

namespace Aedart\Tests\Unit\Properties;


use Aedart\Contracts\Properties\AccessibilityLevels;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Properties\Accessibility\Person;
use Aedart\Tests\TestCases\Properties\PropertiesTestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * AccessibilityTest
 *
 * @group properties
 * @group properties-accessibility
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Properties
 */
class AccessibilityTest extends PropertiesTestCase
{
    /**
     * @test
     */
    public function getDefaultPropertyAccessibilityLevel()
    {
        $method = $this->getMethod('getPropertyAccessibilityLevel');
        $dummy = $this->makeDummy();
        $this->assertEquals(AccessibilityLevels::PROTECTED_LEVEL, $method->invoke($dummy));
    }

    /**
     * @test
     */
    public function setAndGetPropertyAccessibilityLevel()
    {
        $setter = $this->getMethod('setPropertyAccessibilityLevel');
        $getter = $this->getMethod('getPropertyAccessibilityLevel');
        $dummy = $this->makeDummy();

        $setter->invoke($dummy, AccessibilityLevels::PRIVATE_LEVEL);

        $this->assertEquals(AccessibilityLevels::PRIVATE_LEVEL, $getter->invoke($dummy));
    }

    /**
     * @test
     * @expectedException \RangeException
     */
    public function setInvalidPropertyAccessibilityLevel()
    {
        $setter = $this->getMethod('setPropertyAccessibilityLevel');
        $dummy = $this->makeDummy();

        $setter->invoke($dummy, -42);
    }

    /**
     * @test
     */
    public function isPublicPropertyAccessible()
    {
        $isAccessibleMethod = $this->getMethod('isPropertyAccessible');
        $dummy = $this->makeDummy();
        $property = (new ReflectionClass($dummy))->getProperty('name');

        $this->assertTrue($isAccessibleMethod->invoke($dummy, $property));
    }

    /**
     * @test
     */
    public function isProtectedPropertyAccessible()
    {
        $isAccessibleMethod = $this->getMethod('isPropertyAccessible');
        $dummy = $this->makeDummy();
        $property = (new ReflectionClass($dummy))->getProperty('age');

        $this->assertTrue($isAccessibleMethod->invoke($dummy, $property));
    }

    /**
     * @test
     */
    public function isPrivatePropertyAccessible()
    {
        $isAccessibleMethod = $this->getMethod('isPropertyAccessible');
        $dummy = $this->makeDummy();
        $property = (new ReflectionClass($dummy))->getProperty('height');

        // By default, protected is the highest level, so... this must be false!
        $this->assertFalse($isAccessibleMethod->invoke($dummy, $property));
    }
}
