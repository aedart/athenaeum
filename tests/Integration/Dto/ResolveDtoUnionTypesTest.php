<?php

namespace Aedart\Tests\Integration\Dto;

use Aedart\Tests\Helpers\Dummies\Dto\Organisation;
use Aedart\Tests\Helpers\Dummies\Dto\Person;
use Aedart\Tests\TestCases\Dto\DtoTestCase;
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
class ResolveDtoUnionTypesTest extends DtoTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function resolvesScalarTypes()
    {
        $faker = $this->getFaker();

        $dtoA = $this->makeDtoWithUnionTypes([ 'id' => (string) $faker->randomDigitNotNull() ]);
        $dtoB = $this->makeDtoWithUnionTypes([ 'id' => $faker->randomDigitNotNull() ]);
        $dtoC = $this->makeDtoWithUnionTypes([ 'id' => $faker->randomFloat() ]);
        $dtoD = $this->makeDtoWithUnionTypes([ 'id' => $faker->boolean() ]);
        $dtoE = $this->makeDtoWithUnionTypes([ 'id' => null ]);

        $this->assertTrue(isset($dtoA->id), 'Id not set (a: string)');
        $this->assertTrue(isset($dtoB->id), 'Id not set (b: int)');
        $this->assertTrue(isset($dtoC->id), 'Id not set (c: float)');
        $this->assertTrue(isset($dtoD->id), 'Id not set (d: bool)');
        $this->assertFalse(isset($dtoE->id), 'Id set (c: null), but should be null');
    }

    /**
     * @test
     *
     * @return void
     */
    public function resolvesArrayType()
    {
        $faker = $this->getFaker();

        $dtoA = $this->makeDtoWithUnionTypes([ 'data' => $faker->words(3, true) ]);
        $dtoB = $this->makeDtoWithUnionTypes([ 'data' => $faker->words(3) ]);
        $dtoC = $this->makeDtoWithUnionTypes([ 'data' => null ]);

        $this->assertTrue(isset($dtoA->data), 'Data not set (a: string)');
        $this->assertTrue(isset($dtoB->data), 'Data not set (a: array)');
        $this->assertFalse(isset($dtoC->data), 'Data set (b: null), but should be null');
    }

    /**
     * @test
     *
     * @return void
     */
    public function resolvesObjectType()
    {
        $faker = $this->getFaker();

        $dtoA = $this->makeDtoWithUnionTypes([ 'reference' => $faker->words(3, true) ]);
        $dtoB = $this->makeDtoWithUnionTypes([ 'reference' => Person::makeNew([ 'name' => $faker->name() ]) ]);
        $dtoC = $this->makeDtoWithUnionTypes([ 'reference' => [ 'name' => $faker->name() ] ]);
        $dtoD = $this->makeDtoWithUnionTypes([ 'reference' => Organisation::makeNew( ['name' => $faker->company(), 'slogan' => $faker->sentence(4) ] ) ]);
        $dtoE = $this->makeDtoWithUnionTypes([ 'reference' => [ 'name' => $faker->company(), 'slogan' => $faker->sentence(4) ] ]);
        $dtoF = $this->makeDtoWithUnionTypes([ 'reference' => [ 'slogan' => $faker->sentence(4) ] ]);

        $this->assertTrue(isset($dtoA->reference), 'Reference not set (a: string)');

        // Note: both person and organisation have key "name", but since person is defined first,
        // we expect it to be populated
        $this->assertTrue(isset($dtoB->reference), 'Reference not set (b: Person)');
        $this->assertTrue(isset($dtoC->reference), 'Reference not set (c: array -> Person)');
        $this->assertInstanceOf(Person::class, $dtoC->reference);

        // Note: given array data matches the keys of Organisation and not Person, which is what we expect!
        $this->assertTrue(isset($dtoD->reference), 'Reference not set (d: Organisation)');
        $this->assertTrue(isset($dtoE->reference), 'Reference not set (e: array -> Organisation)');
        $this->assertInstanceOf(Organisation::class, $dtoE->reference);

        // Note: keys only match properties in Organisation
        $this->assertTrue(isset($dtoF->reference), 'Reference not set (g: array -> Organisation)');
        $this->assertInstanceOf(Organisation::class, $dtoF->reference);
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsWhenUnableToResolveType()
    {
        $this->expectException(TypeError::class);

        $this->makeDtoWithUnionTypes([ 'reference' => [1, 2, 3] ]);
    }
}
