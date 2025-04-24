<?php

namespace Aedart\Tests\Integration\Dto;

use Aedart\Tests\Helpers\Dummies\Dto\Organisation;
use Aedart\Tests\Helpers\Dummies\Dto\Person;
use Aedart\Tests\TestCases\Dto\DtoTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use DateTimeInterface;
use Illuminate\Support\Carbon;
use JsonException;
use PHPUnit\Framework\Attributes\Test;
use TypeError;

/**
 * ResolveArrayDtoUnionTypesTest
 *
 * @group dto
 * @group dto-union-types
 * @group array-dto-union-types
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Dto
 */
#[Group(
    'dto',
    'dto-union-types',
    'array-dto-union-types'
)]
class ResolveArrayDtoUnionTypesTest extends DtoTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function resolvesScalarTypes()
    {
        $faker = $this->getFaker();

        $dtoA = $this->makeArrayDtoWithUnionTypes([ 'id' => (string) $faker->randomDigitNotNull() ]);
        $this->assertTrue(isset($dtoA->id), 'Id not set (a: string)');
        $this->assertIsString($dtoA->id);

        $dtoB = $this->makeArrayDtoWithUnionTypes([ 'id' => $faker->randomDigitNotNull() ]);
        $this->assertTrue(isset($dtoB->id), 'Id not set (b: int)');
        $this->assertIsInt($dtoB->id);

        $dtoC = $this->makeArrayDtoWithUnionTypes([ 'id' => $faker->randomFloat() ]);
        $this->assertTrue(isset($dtoC->id), 'Id not set (c: float)');
        $this->assertIsFloat($dtoC->id);

        $dtoD = $this->makeArrayDtoWithUnionTypes([ 'id' => $faker->boolean() ]);
        $this->assertTrue(isset($dtoD->id), 'Id not set (d: bool)');
        $this->assertIsBool($dtoD->id);

        $dtoE = $this->makeArrayDtoWithUnionTypes([ 'id' => null ]);
        $this->assertFalse(isset($dtoE->id), 'Id set (c: null), but should be null');
        $this->assertNull($dtoE->id);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws JsonException
     */
    #[Test]
    public function resolvesArrayTypes()
    {
        $faker = $this->getFaker();

        $dtoA = $this->makeArrayDtoWithUnionTypes([ 'content' => Json::encode([ 'body' => $faker->text() ]) ]);
        $this->assertTrue(isset($dtoA->content), 'Content not set (a: json string)');
        $this->assertIsArray($dtoA->content);

        $dtoB = $this->makeArrayDtoWithUnionTypes([ 'content' => [ 'body' => $faker->text() ] ]);
        $this->assertTrue(isset($dtoB->content), 'Content not set (b: array)');
        $this->assertIsArray($dtoB->content);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function resolvesDateTypes()
    {
        $dtoA = $this->makeArrayDtoWithUnionTypes([ 'createdAt' => Carbon::now() ]);
        $this->assertTrue(isset($dtoA->createdAt), 'createdAt not set (a: Datetime / Carbon)');
        $this->assertInstanceOf(DateTimeInterface::class, $dtoA->createdAt);

        $dtoB = $this->makeArrayDtoWithUnionTypes([ 'createdAt' => 'now' ]);
        $this->assertTrue(isset($dtoB->createdAt), 'createdAt not set (a: string (now))');
        $this->assertInstanceOf(DateTimeInterface::class, $dtoB->createdAt);

        $dtoC = $this->makeArrayDtoWithUnionTypes([ 'createdAt' => '+1 week' ]);
        $this->assertTrue(isset($dtoC->createdAt), 'createdAt not set (a: string (+1 week))');
        $this->assertInstanceOf(DateTimeInterface::class, $dtoC->createdAt);

        $dtoD = $this->makeArrayDtoWithUnionTypes([ 'createdAt' => null ]);
        $this->assertFalse(isset($dtoD->createdAt), 'createdAt set (a: null) BUT SHOULD NOT BE');
        $this->assertNull($dtoD->createdAt);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function resolvesObjectTypes()
    {
        $faker = $this->getFaker();

        $dtoA = $this->makeArrayDtoWithUnionTypes([ 'author' => $faker->name() ]);
        $this->assertTrue(isset($dtoA->author), 'Author not set (a: string)');
        $this->assertIsString($dtoA->author);

        $dtoB = $this->makeArrayDtoWithUnionTypes([ 'author' => Person::makeNew([ 'name' => $faker->name() ]) ]);
        $this->assertTrue(isset($dtoB->author), 'Author not set (a: Person)');
        $this->assertInstanceOf(Person::class, $dtoB->author);

        // Note: both person and organisation have key "name", but since person is defined first,
        // we expect it to be populated
        $dtoC = $this->makeArrayDtoWithUnionTypes([ 'author' => [ 'name' => $faker->name() ] ]);
        $this->assertTrue(isset($dtoC->author), 'Author not set (a: array -> Person)');
        $this->assertInstanceOf(Person::class, $dtoC->author);

        $dtoD = $this->makeArrayDtoWithUnionTypes([ 'author' => Organisation::makeNew([ 'name' => $faker->company() ]) ]);
        $this->assertTrue(isset($dtoD->author), 'Author not set (a: Organisation)');
        $this->assertInstanceOf(Organisation::class, $dtoD->author);

        // Note: given array data matches the keys of Organisation and not Person, which is what we expect!
        $dtoE = $this->makeArrayDtoWithUnionTypes([ 'author' => [ 'name' => $faker->company(), 'slogan' => $faker->name() ] ]);
        $this->assertTrue(isset($dtoE->author), 'Author not set (a: array -> Organisation)');
        $this->assertInstanceOf(Organisation::class, $dtoE->author);

        // Note: keys only match properties in Organisation, so this is what we expect!
        $dtoF = $this->makeArrayDtoWithUnionTypes([ 'author' => [ 'slogan' => $faker->sentence(4) ] ]);
        $this->assertTrue(isset($dtoF->author), 'Reference not set (g: array -> Organisation)');
        $this->assertInstanceOf(Organisation::class, $dtoF->author);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function failsWhenUnableToResolveType()
    {
        $this->expectException(TypeError::class);

        $this->makeArrayDtoWithUnionTypes([ 'author' => [1, 2, 3] ]);
    }
}
