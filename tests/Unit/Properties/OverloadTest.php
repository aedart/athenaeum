<?php

namespace Aedart\Tests\Unit\Properties;

use Aedart\Properties\Exceptions\UndefinedProperty;
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
     */
    public function failsOnNoneExistingProperty()
    {
        $this->expectException(UndefinedProperty::class);

        $dummy = $this->makeDummy();
        $dummy->address;
    }

    /**
     * @test
     */
    public function failsPropertyReadWithoutGetter()
    {
        $this->expectException(UndefinedProperty::class);

        $dummy = $this->makeDummy();
        $dummy->age;
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
     */
    public function failsSettingNoneExistingProperty()
    {
        $this->expectException(UndefinedProperty::class);

        $dummy = $this->makeDummy();
        $dummy->age = 98;
    }

    /**
     * @test
     */
    public function failsPropertyWriteWithoutSetter()
    {
        $this->expectException(UndefinedProperty::class);

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

        // NOTE: unset($dummy->name) can yield an error from PHP v8.4, due to possible property hook in
        // subclass. Therefore, here we simply set the property to null.
        // unset($dummy->name);

        $dummy->name = null;

        $this->assertFalse($dummy->isPropSet('name'));
    }

    /**
     * @test
     */
    public function failsUnsetIfPropertyDoesNotExist()
    {
        $this->expectException(UndefinedProperty::class);

        $dummy = $this->makeDummy();
        unset($dummy->jim);
    }
}
