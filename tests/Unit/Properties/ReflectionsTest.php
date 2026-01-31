<?php

namespace Aedart\Tests\Unit\Properties;

use Aedart\Tests\TestCases\Properties\PropertiesTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ReflectionsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Properties
 */
#[Group(
    'properties',
    'properties-reflections'
)]
class ReflectionsTest extends PropertiesTestCase
{
    #[Test]
    public function hasInternalMethod()
    {
        $method = $this->getMethod('hasInternalMethod');
        $dummy = $this->makeDummy();
        $this->assertTrue($method->invoke($dummy, 'myInternalMethod'));
    }

    #[Test]
    public function getInternalProperty()
    {
        $method = $this->getMethod('getInternalProperty');
        $dummy = $this->makeDummy();

        $property = $method->invoke($dummy, 'name');
        $property->setAccessible(true);

        $this->assertSame('John Doe', $property->getValue($dummy));
    }

    #[Test]
    public function doesNotHaveInternalProperty()
    {
        $method = $this->getMethod('hasInternalProperty');
        $dummy = $this->makeDummy();

        // This property doesn't exist
        $this->assertFalse($method->invoke($dummy, 'job'));
    }

    #[Test]
    public function hasAccessibleInternalProperty()
    {
        $method = $this->getMethod('hasInternalProperty');
        $dummy = $this->makeDummy();

        // By default only protected properties should be flagged accessible
        $this->assertTrue($method->invoke($dummy, 'name'));
    }

    #[Test]
    public function hasInaccessibleInternalProperty()
    {
        $method = $this->getMethod('hasInternalProperty');
        $dummy = $this->makeDummy();

        // By default only protected properties should be flagged accessible - not private
        $this->assertFalse($method->invoke($dummy, 'height'));
    }
}
