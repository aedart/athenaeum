<?php

namespace Aedart\Tests\Unit\Properties;

use Aedart\Properties\Exceptions\UndefinedProperty;
use Aedart\Tests\TestCases\Properties\PropertiesTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * OverloadTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Properties
 */
#[Group(
    'properties',
    'properties-overload'
)]
class OverloadTest extends PropertiesTestCase
{
    #[Test]
    public function canReadAccessibleProperty()
    {
        $dummy = $this->makeDummy();
        $this->assertSame('John Doe', $dummy->name);
    }

    #[Test]
    public function failsOnNoneExistingProperty()
    {
        $this->expectException(UndefinedProperty::class);

        $dummy = $this->makeDummy();
        $dummy->address;
    }

    #[Test]
    public function failsPropertyReadWithoutGetter()
    {
        $this->expectException(UndefinedProperty::class);

        $dummy = $this->makeDummy();
        $dummy->age;
    }

    #[Test]
    public function canSetAccessibleProperty()
    {
        $dummy = $this->makeDummy();
        $newName = 'Andrew Brewman';

        $dummy->name = $newName;

        $this->assertSame($newName, $dummy->getName());
    }

    #[Test]
    public function canHandleFluentReturnForSetter()
    {
        $dummy = $this->makeDummy();
        $newName = 'Jim Marco';

        $result = $dummy->setName($newName);

        $this->assertSame($dummy, $result);
    }

    #[Test]
    public function failsSettingNoneExistingProperty()
    {
        $this->expectException(UndefinedProperty::class);

        $dummy = $this->makeDummy();
        $dummy->age = 98;
    }

    #[Test]
    public function failsPropertyWriteWithoutSetter()
    {
        $this->expectException(UndefinedProperty::class);

        $dummy = $this->makeDummy();
        $dummy->age = 'Brian Conner';
    }

    #[Test]
    public function canDetermineIfPropertyIsset()
    {
        $dummy = $this->makeDummy();
        $this->assertTrue(isset($dummy->name));
    }

    #[Test]
    public function canDetermineIfPropertyIsNotSet()
    {
        $dummy = $this->makeDummy();
        $dummy->unsetName();
        $this->assertFalse(isset($dummy->name));
    }

    #[Test]
    public function canDetermineIfNoneExistingPropertyIsset()
    {
        $dummy = $this->makeDummy();
        $this->assertFalse(isset($dummy->rick));
    }

    #[Test]
    public function canUnsetProperty()
    {
        $dummy = $this->makeDummy();

        // NOTE: unset($dummy->name) can yield an error from PHP v8.4, due to possible property hook in
        // subclass. Therefore, here we simply set the property to null.
        // unset($dummy->name);

        $dummy->name = null;

        $this->assertFalse($dummy->isPropSet('name'));
    }

    #[Test]
    public function failsUnsetIfPropertyDoesNotExist()
    {
        $this->expectException(UndefinedProperty::class);

        $dummy = $this->makeDummy();
        unset($dummy->jim);
    }
}
