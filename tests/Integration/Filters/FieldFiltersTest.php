<?php

namespace Aedart\Tests\Integration\Filters;

use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Filters\Query\Filters\Fields\BooleanFilter;
use Aedart\Filters\Query\Filters\Fields\DatetimeFilter;
use Aedart\Filters\Query\Filters\Fields\NumericFilter;
use Aedart\Filters\Query\Filters\Fields\StringFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;

/**
 * FieldFiltersTest
 *
 * @group filters
 * @group filters-fields
 * @group filters-numeric
 * @group filters-boolean
 * @group filters-datetime
 * @group filters-string
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Filters
 */
class FieldFiltersTest extends FiltersTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides field filters and args...
     *
     * @return array[]
     */
    public function providersFieldFilters(): array
    {
        $faker = $this->getFaker();

        return [
            'numeric' => [
                NumericFilter::class,
                'id',
                'gt',
                $faker->randomDigitNotNull
            ],

            'numeric (null)' => [
                NumericFilter::class,
                'id',
                'is_null',
                null
            ],

            'numeric (in)' => [
                NumericFilter::class,
                'id',
                'in',
                '1,2,3,4'
            ],

            'boolean' => [
                BooleanFilter::class,
                'is_admin',
                'eq',
                'yes'
            ],

            'datetime' => [
                DatetimeFilter::class,
                'updated_at',
                'lt',
                $faker->date('Y-m-d')
            ],

            'string' => [
                StringFilter::class,
                'description',
                'not_in',
                'a,b,c,d'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providersFieldFilters
     *
     * @param string $class FieldCriteria class path
     * @param string $field
     * @param string $operator
     * @param mixed $value
     */
    public function canBeApplied(string $class, string $field, string $operator, $value)
    {
        /** @var FieldCriteria $filter */
        $filter = new $class($field, $operator, $value);

        $query = $filter->apply(Category::query());
        $sql = $query->toSql();

        ConsoleDebugger::output($sql);

        // The only thing we can safely test for, is the field that is requested.
        // In addition, the operator might NOT correspond directly to an operator in sql...
        $this->assertStringContainsString($field, $sql);
    }
}
