<?php

namespace Aedart\Tests\Integration\Dto;

use Aedart\Properties\Exceptions\UndefinedProperty;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Dto\Organisation;
use Aedart\Tests\TestCases\Dto\DtoTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ArrayDtoTest
 *
 * @group dto
 * @group array-dto
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Dto
 */
#[Group(
    'dto',
    'array-dto',
)]
class ArrayDtoTest extends DtoTestCase
{
    /**
     * @test
     */
    #[Test]
    public function canCreateInstance()
    {
        $dto = $this->makeArrayDto();

        $this->assertNotNull($dto);
    }

    /**
     * @test
     */
    #[Test]
    public function canCreateInstanceWithProperties()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);

        $this->assertSame($data['name'], $dto->name);
        $this->assertSame($data['employees'], $dto->employees);
    }

    /**
     * @test
     */
    #[Test]
    public function canDetermineIfExists()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);

        $this->assertTrue(isset($dto['name']), 'Name should exist');
        $this->assertTrue(isset($dto['employees']), 'Employees should exist');
        $this->assertFalse(isset($dto['unknownProperty']), 'Unknown property should NOT Exist');
    }

    /**
     * @test
     */
    #[Test]
    public function canGetAndSetProperty()
    {
        $name = $this->faker->name();
        $employees = $this->faker->randomNumber();

        $dto = $this->makeArrayDto();
        $dto['name'] = $name;
        $dto['employees'] = $employees;

        $this->assertSame($name, $dto['name']);
        $this->assertSame($employees, $dto['employees']);
    }

    /**
     * @test
     */
    #[Test]
    public function failsReadingWhenPropertyDoesNotExist()
    {
        $this->expectException(UndefinedProperty::class);

        $dto = $this->makeArrayDto();
        $dto['myUnknownProperty'];
    }

    /**
     * @test
     */
    #[Test]
    public function failsWritingWhenPropertyDoesNotExist()
    {
        $this->expectException(UndefinedProperty::class);

        $dto = $this->makeArrayDto();
        $dto['myUnknownProperty'] = 42;
    }

    /**
     * @test
     */
    #[Test]
    public function canUnsetProperty()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);
        unset($dto['name']);

        $this->assertFalse(isset($dto['name']));
    }

    /**
     * @test
     */
    #[Test]
    public function canBeJsonSerialised()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);
        $encoded = Json::encode($dto);

        ConsoleDebugger::output($encoded);
        $this->assertJson($encoded);
    }

    /**
     * @test
     */
    #[Test]
    public function canBeExportedToJson()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);
        $encoded = $dto->toJson(JSON_PRETTY_PRINT);

        ConsoleDebugger::output($encoded);
        $this->assertJson($encoded);
    }

    /**
     * @test
     */
    #[Test]
    public function canBeSerialisedAndUnserialised()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);
        $serialised = serialize($dto);

        ConsoleDebugger::output('Serialised', $serialised);
        $this->assertIsString($serialised, 'Invalid serialised format');

        $newDto = unserialize($serialised);
        ConsoleDebugger::output('Unserialize', $serialised);
        $this->assertSame($data['name'], $newDto['name']);
        $this->assertSame($data['age'], $newDto['age']);
    }

    /**
     * @test
     */
    #[Test]
    public function canBeRepresentedAsString()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);
        $encoded = (string) $dto;

        ConsoleDebugger::output($encoded);
        $this->assertIsString($encoded);
    }

    /**
     * @test
     */
    #[Test]
    public function canCreateInstanceFromJson()
    {
        $json = '{"name":"Stacy Douglas","employees":54}';

        $dto = Organisation::fromJson($json);

        $this->assertSame('Stacy Douglas', $dto['name']);
        $this->assertSame(54, $dto['employees']);
    }

    /**
     * @test
     */
    #[Test]
    public function canObtainDebugInfo()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);

        $result = $dto->__debugInfo();

        ConsoleDebugger::output($result);
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    /**
     * @test
     */
    #[Test]
    public function debugInfoDoesNotContainUnsetProperty()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);

        unset($dto['name']);
        $result = $dto->__debugInfo();

        ConsoleDebugger::output($result);
        $keys = array_keys($result);
        $this->assertNotContains('name', $keys);
    }
}
