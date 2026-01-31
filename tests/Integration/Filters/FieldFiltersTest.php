<?php

namespace Aedart\Tests\Integration\Filters;

use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Filters\Query\Filters\Fields\BooleanFilter;
use Aedart\Filters\Query\Filters\Fields\DateFilter;
use Aedart\Filters\Query\Filters\Fields\DatetimeFilter;
use Aedart\Filters\Query\Filters\Fields\NumericFilter;
use Aedart\Filters\Query\Filters\Fields\StringFilter;
use Aedart\Filters\Query\Filters\Fields\UTCDatetimeFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * FieldFiltersTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters
 */
#[Group(
    'filters',
    'filters-fields',
    'filters-numeric',
    'filters-boolean',
    'filters-datetime',
    'filters-string',
)]
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
                $faker->randomDigitNotNull()
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

            'date' => [
                DateFilter::class,
                'created_at',
                'eq',
                $faker->date('Y-m-d')
            ],

            'datetime' => [
                DatetimeFilter::class,
                'updated_at',
                'eq',
                $faker->date('Y-m-d H:i:s')
            ],

            'UTC datetime' => [
                UTCDatetimeFilter::class,
                'deleted_at',
                'gt',
                $faker->date('Y-m-d H:i:s')
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
     * @param string $class FieldCriteria class path
     * @param string $field
     * @param string $operator
     * @param mixed $value
     */
    #[DataProvider('providersFieldFilters')]
    #[Test]
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
