<?php

namespace Aedart\Tests\Integration\Dto;

use Aedart\Tests\Helpers\Dummies\Dto\Organisation;
use Aedart\Tests\Helpers\Dummies\Dto\Person;
use Aedart\Tests\TestCases\Dto\DtoTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use TypeError;

/**
 * ResolveDtoUnionTypesTest
 *
 * @group dto
 * @group dto-union-types
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Dto
 */
#[Group(
    'dto',
    'dto-union-types',
)]
class ResolveDtoUnionTypesTest extends DtoTestCase
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

        $dtoA = $this->makeDtoWithUnionTypes([ 'id' => (string) $faker->randomDigitNotNull() ]);
        $this->assertTrue(isset($dtoA->id), 'Id not set (a: string)');
        $this->assertIsString($dtoA->id);

        $dtoB = $this->makeDtoWithUnionTypes([ 'id' => $faker->randomDigitNotNull() ]);
        $this->assertTrue(isset($dtoB->id), 'Id not set (b: int)');
        $this->assertIsInt($dtoB->id);

        $dtoC = $this->makeDtoWithUnionTypes([ 'id' => $faker->randomFloat() ]);
        $this->assertTrue(isset($dtoC->id), 'Id not set (c: float)');
        $this->assertIsFloat($dtoC->id);

        $dtoD = $this->makeDtoWithUnionTypes([ 'id' => $faker->boolean() ]);
        $this->assertTrue(isset($dtoD->id), 'Id not set (d: bool)');
        $this->assertIsBool($dtoD->id);

        $dtoE = $this->makeDtoWithUnionTypes([ 'id' => null ]);
        $this->assertFalse(isset($dtoE->id), 'Id set (c: null), but should be null');
        $this->assertNull($dtoE->id);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function resolvesArrayType()
    {
        $faker = $this->getFaker();

        $dtoA = $this->makeDtoWithUnionTypes([ 'data' => $faker->words(3, true) ]);
        $this->assertTrue(isset($dtoA->data), 'Data not set (a: string)');

        $dtoB = $this->makeDtoWithUnionTypes([ 'data' => $faker->words(3) ]);
        $this->assertTrue(isset($dtoB->data), 'Data not set (a: array)');

        $dtoC = $this->makeDtoWithUnionTypes([ 'data' => null ]);
        $this->assertFalse(isset($dtoC->data), 'Data set (b: null), but should be null');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function resolvesObjectType()
    {
        $faker = $this->getFaker();

        $dtoA = $this->makeDtoWithUnionTypes([ 'reference' => $faker->words(3, true) ]);
        $this->assertTrue(isset($dtoA->reference), 'Reference not set (a: string)');

        // Note: both person and organisation have key "name", but since person is defined first,
        // we expect it to be populated
        $dtoB = $this->makeDtoWithUnionTypes([ 'reference' => Person::makeNew([ 'name' => $faker->name() ]) ]);
        $this->assertTrue(isset($dtoB->reference), 'Reference not set (b: Person)');

        $dtoC = $this->makeDtoWithUnionTypes([ 'reference' => [ 'name' => $faker->name() ] ]);
        $this->assertTrue(isset($dtoC->reference), 'Reference not set (c: array -> Person)');
        $this->assertInstanceOf(Person::class, $dtoC->reference);

        // Note: given array data matches the keys of Organisation and not Person, which is what we expect!
        $dtoD = $this->makeDtoWithUnionTypes([ 'reference' => Organisation::makeNew(['name' => $faker->company(), 'slogan' => $faker->sentence(4) ]) ]);
        $this->assertTrue(isset($dtoD->reference), 'Reference not set (d: Organisation)');

        $dtoE = $this->makeDtoWithUnionTypes([ 'reference' => [ 'name' => $faker->company(), 'slogan' => $faker->sentence(4) ] ]);
        $this->assertTrue(isset($dtoE->reference), 'Reference not set (e: array -> Organisation)');
        $this->assertInstanceOf(Organisation::class, $dtoE->reference);

        // Note: keys only match properties in Organisation
        $dtoF = $this->makeDtoWithUnionTypes([ 'reference' => [ 'slogan' => $faker->sentence(4) ] ]);
        $this->assertTrue(isset($dtoF->reference), 'Reference not set (f: array -> Organisation)');
        $this->assertInstanceOf(Organisation::class, $dtoF->reference);
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

        $this->makeDtoWithUnionTypes([ 'reference' => [1, 2, 3] ]);
    }
}
