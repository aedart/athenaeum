<?php

namespace Aedart\Tests\Unit\Properties;

use Aedart\Tests\TestCases\Properties\PropertiesTestCase;

/**
 * OverloadTest
 *
 * @group properties
 * @group properties-overload
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Properties
 */
class OverloadTest extends PropertiesTestCase
{
    /**
     * @test
     */
    public function canReadAccessibleProperty()
    {
        $dummy = $this->makeDummy();
        $this->assertSame('John Doe', $dummy->name);
    }

    /**
     * @test
     * @expectedException \Aedart\Properties\Exceptions\UndefinedProperty
     */
    public function failsOnNoneExistingProperty()
    {
        $dummy = $this->makeDummy();
        $x = $dummy->address;
    }

    /**
     * @test
     * @expectedException \Aedart\Properties\Exceptions\UndefinedProperty
     */
    public function failsPropertyReadWithoutGetter()
    {
        $dummy = $this->makeDummy();
        $x = $dummy->age;
    }

    /**
     * @test
     */
    public function canSetAccessibleProperty()
    {
        $dummy = $this->makeDummy();
        $newName = 'Andrew Brewman';

        $dummy->name = $newName;

        $this->assertSame($newName, $dummy->getName());
    }

    /**
     * @test
     */
    public function canHandleFluentReturnForSetter()
    {
        $dummy = $this->makeDummy();
        $newName = 'Jim Marco';

        $result = $dummy->setName($newName);

        $this->assertSame($dummy, $result);
    }

    /**
     * @test
     * @expectedException \Aedart\Properties\Exceptions\UndefinedProperty
     */
    public function failsSettingNoneExistingProperty()
    {
        $dummy = $this->makeDummy();
        $dummy->age = 98;
    }

    /**
     * @test
     * @expectedException \Aedart\Properties\Exceptions\UndefinedProperty
     */
    public function failsPropertyWriteWithoutSetter()
    {
        $dummy = $this->makeDummy();
        $dummy->age = 'Brian Conner';
    }

    /**
     * @test
     */
    public function canDetermineIfPropertyIsset()
    {
        $dummy = $this->makeDummy();
        $this->assertTrue(isset($dummy->name));
    }

    /**
     * @test
     */
    public function canDetermineIfPropertyIsNotSet()
    {
        $dummy = $this->makeDummy();
        $dummy->unsetName();
        $this->assertFalse(isset($dummy->name));
    }

    /**
     * @test
     */
    public function canDetermineIfNoneExistingPropertyIsset()
    {
        $dummy = $this->makeDummy();
        $this->assertFalse(isset($dummy->rick));
    }

    /**
     * @test
     */
    public function canUnsetProperty()
    {
        $dummy = $this->makeDummy();
        unset($dummy->name);
        $this->assertFalse($dummy->isPropSet('name'));
    }

    /**
     * @test
     * @expectedException \Aedart\Properties\Exceptions\UndefinedProperty
     */
    public function failsUnsetIfPropertyDoesNotExist()
    {
        $dummy = $this->makeDummy();
        unset($dummy->jim);
    }
}
