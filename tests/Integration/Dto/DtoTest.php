<?php

namespace Aedart\Tests\Integration\Dto;

use Aedart\Properties\Exceptions\UndefinedProperty;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Dto\Person;
use Aedart\Tests\TestCases\Dto\DtoTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * DtoTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Dto
 */
#[Group(
    'dto',
)]
class DtoTest extends DtoTestCase
{
    #[Test]
    public function canCreateInstance()
    {
        $dto = $this->makeDto();

        $this->assertNotNull($dto);
    }

    #[Test]
    public function canCreateInstanceWithProperties()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);

        $this->assertSame($data['name'], $dto->name);
        $this->assertSame($data['age'], $dto->age);
    }

    #[Test]
    public function canDetermineIfExists()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);

        $this->assertTrue(isset($dto['name']), 'Name exists');
        $this->assertTrue(isset($dto['age']), 'Age exists');
        $this->assertFalse(isset($dto['unknownProperty']), 'Unknown property should NOT Exist');
    }

    #[Test]
    public function canGetAndSetProperty()
    {
        $name = $this->faker->name();
        $age = $this->faker->randomNumber();

        $dto = $this->makeDto();
        $dto['name'] = $name;
        $dto['age'] = $age;

        $this->assertSame($name, $dto['name']);
        $this->assertSame($age, $dto['age']);
    }

    #[Test]
    public function failsReadingWhenPropertyDoesNotExist()
    {
        $this->expectException(UndefinedProperty::class);

        $dto = $this->makeDto();
        $dto['myUnknownProperty'];
    }

    #[Test]
    public function failsWritingWhenPropertyDoesNotExist()
    {
        $this->expectException(UndefinedProperty::class);

        $dto = $this->makeDto();
        $dto['myUnknownProperty'] = 42;
    }

    #[Test]
    public function canUnsetProperty()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);
        unset($dto['name']);

        $this->assertFalse(isset($dto['name']));
    }

    #[Test]
    public function canBeJsonSerialised()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);
        $encoded = Json::encode($dto);

        ConsoleDebugger::output($encoded);
        $this->assertJson($encoded);
    }

    #[Test]
    public function canBeExportedToJson()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);
        $encoded = $dto->toJson(JSON_PRETTY_PRINT);

        ConsoleDebugger::output($encoded);
        $this->assertJson($encoded);
    }

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

    #[Test]
    public function canBeRepresentedAsString()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);
        $encoded = (string) $dto;

        ConsoleDebugger::output($encoded);
        $this->assertIsString($encoded);
    }

    #[Test]
    public function canCreateInstanceFromJson()
    {
        $json = '{"name":"Stacy Douglas","age":67571179}';

        $dto = Person::fromJson($json);

        $this->assertSame('Stacy Douglas', $dto['name']);
        $this->assertSame(67571179, $dto['age']);
    }

    #[Test]
    public function canObtainDebugInfo()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber()
        ];

        $dto = $this->makeDto($data);

        $result = $dto->__debugInfo();

        ConsoleDebugger::output($result);
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }
}
