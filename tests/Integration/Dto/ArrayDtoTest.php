<?php

namespace Aedart\Tests\Integration\Dto;


use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Dto\Organisation;
use Aedart\Tests\TestCases\Dto\DtoTestCase;
use Aedart\Utils\Json;

/**
 * ArrayDtoTest
 *
 * @group dto
 * @group array-dto
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Dto
 */
class ArrayDtoTest extends DtoTestCase
{
    /**
     * @test
     */
    public function canCreateInstance()
    {
        $dto = $this->makeArrayDto();

        $this->assertNotNull($dto);
    }

    /**
     * @test
     */
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
    public function canGetAndSetProperty()
    {
        $name = $this->faker->name;
        $employees = $this->faker->randomNumber();

        $dto = $this->makeArrayDto();
        $dto['name'] = $name;
        $dto['employees'] = $employees;

        $this->assertSame($name, $dto['name']);
        $this->assertSame($employees, $dto['employees']);
    }

    /**
     * @test
     * @expectedException \Aedart\Properties\Exceptions\UndefinedProperty
     */
    public function failsReadingWhenPropertyDoesNotExist()
    {
        $dto = $this->makeArrayDto();
        $prop = $dto['myUnknownProperty'];
    }

    /**
     * @test
     * @expectedException \Aedart\Properties\Exceptions\UndefinedProperty
     */
    public function failsWritingWhenPropertyDoesNotExist()
    {
        $dto = $this->makeArrayDto();
        $dto['myUnknownProperty'] = 42;
    }

    /**
     * @test
     */
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
    public function canBeSerialised()
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
    public function canBeRepresentedAsString()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);
        $encoded = (string) $dto;

        ConsoleDebugger::output($encoded);
        $this->assertInternalType('string', $encoded);
    }

    /**
     * @test
     */
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
    public function canObtainDebugInfo()
    {
        $data = $this->arrayDtoData();

        $dto = $this->makeArrayDto($data);

        $result = $dto->__debugInfo();

        ConsoleDebugger::output($result);
        $this->assertInternalType('array', $result);
        $this->assertNotEmpty($result);
    }

    /**
     * @test
     */
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
