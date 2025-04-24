<?php

namespace Aedart\Tests\Integration\Dto;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Contracts\Note as NoteInterface;
use Aedart\Tests\Helpers\Dummies\Dto\Address;
use Aedart\Tests\Helpers\Dummies\Dto\City;
use Aedart\Tests\Helpers\Dummies\Dto\Note;
use Aedart\Tests\TestCases\Dto\DtoTestCase;
use Codeception\Attribute\Group;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Attributes\Test;

/**
 * NestedDtoTest
 *
 * @group dto
 * @group dto-nested
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Dto
 */
#[Group(
    'dto',
    'dto-nested',
)]
class NestedDtoTest extends DtoTestCase
{
    /**
     * @test
     */
    #[Test]
    public function canPopulateWithObjects()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber(),

            'address' => new Address([
                'street' => $this->faker->streetName(),

                'city' => new City([
                    'name' => $this->faker->city(),
                    'zipCode' => $this->faker->randomNumber(4),
                ])
            ])
        ];

        $dto = $this->makeDto($data);

        ConsoleDebugger::output($dto);
        $this->assertSame($data['address'], $dto->address);
        $this->assertSame($data['address']['city'], $dto->address->city);
    }

    /**
     * @test
     */
    #[Test]
    public function canResolveUnboundInstances()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber(),
            'address' => [
                'street' => $this->faker->streetName(),
                'city' => [
                    'name' => $this->faker->city(),
                    'zipCode' => $this->faker->randomNumber(4),
                ]
            ]
        ];

        $dto = $this->makeDto($data);

        ConsoleDebugger::output($dto);
        $this->assertSame($data['address']['street'], $dto->address->street);
        $this->assertSame($data['address']['city']['name'], $dto->address->city->name);
    }

    /**
     * @test
     */
    #[Test]
    public function failsResolvingWhenNoServiceContainerAvailable()
    {
        $this->expectException(BindingResolutionException::class);

        $this->ioc->destroy();

        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber(),
            'address' => [
                'street' => $this->faker->streetName(),
                'city' => [
                    'name' => $this->faker->city(),
                    'zipCode' => $this->faker->randomNumber(4),
                ]
            ]
        ];

        $this->makeDto($data);
    }

    /**
     * @test
     */
    #[Test]
    public function canJsonSerialiseNestedInstances()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber(),
            'address' => [
                'street' => $this->faker->streetName(),
                'city' => [
                    'name' => $this->faker->city(),
                    'zipCode' => $this->faker->randomNumber(4),
                ]
            ]
        ];

        $dto = $this->makeDto($data);
        $result = $dto->toJson(JSON_PRETTY_PRINT);

        ConsoleDebugger::output($result);
        $this->assertJson($result);
    }

    /**
     * @test
     */
    #[Test]
    public function canSerialiseNestedInstances()
    {
        $data = [
            'name' => $this->faker->name(),
            'age' => $this->faker->randomNumber(),
            'address' => [
                'street' => $this->faker->streetName(),
                'city' => [
                    'name' => $this->faker->city(),
                    'zipCode' => $this->faker->randomNumber(4),
                ]
            ]
        ];

        $dto = $this->makeDto($data);
        $serialised = serialize($dto);

        ConsoleDebugger::output('Serialised', $serialised);
        $this->assertIsString($serialised, 'Invalid serialised format');

        $newDto = unserialize($serialised);
        ConsoleDebugger::output('Unserialize', $serialised);

        $address = $newDto['address'];
        $this->assertInstanceOf(Address::class, $address, 'Unable to unserialise nested DTO');
        $this->assertSame($data['address']['city']['name'], $address['city']['name'], 'Invalid unserialised nested dto property');
    }

    /**
     * @test
     */
    #[Test]
    public function canResolveUsingOverloadMethodDirectly()
    {
        $dto = $this->makeDto();

        $data = [
            'street' => $this->faker->streetName(),
            'city' => [
                'name' => $this->faker->city(),
                'zipCode' => $this->faker->randomNumber(4)
            ]
        ];

        $dto->address = $data;

        $this->assertSame($data['city']['zipCode'], $dto->address->city->zipCode, 'ZipCode was expected to be of a different value!');
    }

    /**
     * @test
     */
    #[Test]
    public function canResolveBoundAbstractInstance()
    {
        // Bind the abstraction / interface
        $this->ioc->bind(NoteInterface::class, function ($app) {
            return new Note();
        });

        $data = [
            'name' => $this->faker->name(),
            'address' => [
                'street' => $this->faker->streetName(),
                'city' => [
                    'name' => $this->faker->city(),
                    'zipCode' => (int) $this->faker->postcode()
                ]
            ],

            // Here, the interface is bound, thus this should
            // not fail
            'note' => [
                'content' => $this->faker->sentence()
            ]
        ];

        $dto = $this->makeDto($data);

        ConsoleDebugger::output($dto);
        $expected = $data['note']['content'];
        $content = $dto->note->getContent();

        $this->assertSame($expected, $content);
    }

    /**
     * @test
     */
    #[Test]
    public function failsResolvingAbstractInstance()
    {
        // NOTE: Here the interface is not bound. The IoC should thus fail resolving.

        $this->expectException(BindingResolutionException::class);

        $data = [
            'name' => $this->faker->name(),
            'address' => [
                'street' => $this->faker->streetName(),
                'city' => [
                    'name' => $this->faker->city(),
                    'zipCode' => (int) $this->faker->postcode()
                ]
            ],

            // Here, the interface is bound, thus this should
            // not fail
            'note' => [
                'content' => $this->faker->sentence()
            ]
        ];

        $this->makeDto($data);
    }
}
