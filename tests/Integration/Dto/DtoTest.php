<?php

namespace Aedart\Tests\Integration\Dto;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Dto\DtoTestCase;
use Aedart\Utils\Json;

/**
 * DtoTest
 *
 * @group dto
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Dto
 */
class DtoTest extends DtoTestCase
{
    /**
     * @test
     */
    public function canCreateInstance()
    {
        $dto = $this->makeDto();

        $this->assertNotNull($dto);
    }

    /**
     * @test
     */
    public function canCreateInstanceWithProperties()
    {
        $data = [
            'name'  => $this->faker->name,
            'age'   => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);

        $this->assertSame($data['name'], $dto->name);
        $this->assertSame($data['age'], $dto->age);
    }

    /**
     * @test
     */
    public function canDetermineIfExists()
    {
        $data = [
            'name'  => $this->faker->name,
            'age'   => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);

        $this->assertTrue(isset($dto['name']), 'Name exists');
        $this->assertTrue(isset($dto['age']), 'Age exists');
        $this->assertFalse(isset($dto['unknownProperty']), 'Unknown property should NOT Exist');
    }

    /**
     * @test
     */
    public function canGetAndSetProperty()
    {
        $name = $this->faker->name;
        $age = $this->faker->randomNumber();

        $dto = $this->makeDto();
        $dto['name'] = $name;
        $dto['age'] = $age;

        $this->assertSame($name, $dto['name']);
        $this->assertSame($age, $dto['age']);
    }

    /**
     * @test
     * @expectedException \Aedart\Properties\Exceptions\UndefinedProperty
     */
    public function failsReadingWhenPropertyDoesNotExist()
    {
        $dto = $this->makeDto();
        $prop = $dto['myUnknownProperty'];
    }

    /**
     * @test
     * @expectedException \Aedart\Properties\Exceptions\UndefinedProperty
     */
    public function failsWritingWhenPropertyDoesNotExist()
    {
        $dto = $this->makeDto();
        $dto['myUnknownProperty'] = 42;
    }

    /**
     * @test
     */
    public function canUnsetProperty()
    {
        $data = [
            'name'  => $this->faker->name,
            'age'   => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);
        unset($dto['name']);

        $this->assertFalse(isset($dto['name']));
    }

    /**
     * @test
     */
    public function canBeSerialised()
    {
        $data = [
            'name'  => $this->faker->name,
            'age'   => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);
        $encoded = Json::encode($dto);

        ConsoleDebugger::output($encoded);
        $this->assertJson($encoded);
    }

    /**
     * @test
     */
    public function canBeExportedToJson()
    {
        $data = [
            'name'  => $this->faker->name,
            'age'   => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);
        $encoded = $dto->toJson(JSON_PRETTY_PRINT);

        ConsoleDebugger::output($encoded);
        $this->assertJson($encoded);
    }

    /**
     * @test
     */
    public function canBeRepresentedAsString()
    {
        $data = [
            'name'  => $this->faker->name,
            'age'   => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);
        $encoded = (string) $dto;

        ConsoleDebugger::output($encoded);
        $this->assertInternalType('string', $encoded);
    }

    /**
     * @test
     */
    public function canObtainDebugInfo()
    {
        $data = [
            'name'  => $this->faker->name,
            'age'   => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);

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
        $data = [
            'name'  => $this->faker->name,
            'age'   => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);

        unset($dto['name']);
        $result = $dto->__debugInfo();

        ConsoleDebugger::output($result);
        $keys = array_keys($result);
        $this->assertNotContains('name', $keys);
    }
}
