<?php

namespace Aedart\Tests\Unit\Properties;

use Aedart\Tests\TestCases\Properties\PropertiesTestCase;

/**
 * ReflectionsTest
 *
 * @group properties
 * @group properties-reflections
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Properties
 */
class ReflectionsTest extends PropertiesTestCase
{
    /**
     * @test
     */
    public function hasInternalMethod()
    {
        $method = $this->getMethod('hasInternalMethod');
        $dummy = $this->makeDummy();
        $this->assertTrue($method->invoke($dummy, 'myInternalMethod'));
    }

    /**
     * @test
     */
    public function getInternalProperty()
    {
        $method = $this->getMethod('getInternalProperty');
        $dummy = $this->makeDummy();

        $property = $method->invoke($dummy, 'name');
        $property->setAccessible(true);

        $this->assertSame('John Doe', $property->getValue($dummy));
    }

    /**
     * @test
     */
    public function doesNotHaveInternalProperty()
    {
        $method = $this->getMethod('hasInternalProperty');
        $dummy = $this->makeDummy();

        // This property doesn't exist
        $this->assertFalse($method->invoke($dummy, 'job'));
    }

    /**
     * @test
     */
    public function hasAccessibleInternalProperty()
    {
        $method = $this->getMethod('hasInternalProperty');
        $dummy = $this->makeDummy();

        // By default only protected properties should be flagged accessible
        $this->assertTrue($method->invoke($dummy, 'name'));
    }

    /**
     * @test
     */
    public function hasInaccessibleInternalProperty()
    {
        $method = $this->getMethod('hasInternalProperty');
        $dummy = $this->makeDummy();

        // By default only protected properties should be flagged accessible - not private
        $this->assertFalse($method->invoke($dummy, 'height'));
    }
}
