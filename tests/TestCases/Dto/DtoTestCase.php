<?php

namespace Aedart\Tests\TestCases\Dto;

use Aedart\Testing\TestCases\IntegrationTestCase;
use Aedart\Tests\Helpers\Dummies\Dto\Article;
use Aedart\Tests\Helpers\Dummies\Dto\Organisation;
use Aedart\Tests\Helpers\Dummies\Dto\Person;
use Aedart\Tests\Helpers\Dummies\Dto\Record;
use Carbon\Carbon;

/**
 * DTo Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Dto
 */
abstract class DtoTestCase extends IntegrationTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a new Dto instance
     *
     * @param array $data [optional]
     * @return Person
     *
     * @throws \Throwable
     */
    public function makeDto(array $data = []): Person
    {
        return Person::makeNew($data);
    }

    /**
     * Returns a new Array-Dto instance
     *
     * @param array $data [optional]
     *
     * @return Organisation
     */
    public function makeArrayDto(array $data = []): Organisation
    {
        return Organisation::makeNew($data);
    }

    /**
     * Returns new Dto instance that declares some setters with union types
     *
     * @param  array  $data  [optional]
     *
     * @return Record
     */
    public function makeDtoWithUnionTypes(array $data = []): Record
    {
        return Record::makeNew($data);
    }

    /**
     * Returns new Array Dto instance that declares union types as allowed
     * properties
     *
     * @param  array  $data  [optional]
     *
     * @return Article
     */
    public function makeArrayDtoWithUnionTypes(array $data = []): Article
    {
        return Article::makeNew($data);
    }

    /*****************************************************************
     * Fakers
     ****************************************************************/

    /**
     * Generates random data for an Organisation Dto
     *
     * @return array
     */
    public function arrayDtoData(): array
    {
        return [
            'name' => $this->faker->name(),
            'slogan' => $this->faker->words(3, true),
            'employees' => $this->faker->randomDigitNotNull(),
            'hasInsurance' => $this->faker->boolean(),
            'profitScore' => (string) $this->faker->randomFloat(2, 0, 10),
            'persons' => $this->faker->randomElements([
                'Jessey',
                'Arline',
                'Mark',
                'Ole'
            ], 2),
            'started' => Carbon::now()->toIso8601String()
        ];
    }
}
