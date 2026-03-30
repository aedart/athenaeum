<?php

namespace Aedart\Tests\Integration\Filters\Processors;

use Aedart\Contracts\Utils\Dates\DateTimeFormats;
use Aedart\Filters\Processors\ConstraintsProcessor;
use Aedart\Filters\Query\Filters\Fields\DatetimeFilter;
use Aedart\Filters\Query\Filters\Fields\NumericFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ConstraintsProcessorTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters\Processors
 */
#[Group(
    'filters',
    'filters-constraints-processor',
)]
class ConstraintsProcessorTest extends FiltersTestCase
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[Test]
    public function canBuildSearchQuery()
    {
        // NOTE: In this test we do not focus on all the types of field filters
        // that the "filters" package offers. Only that the processor is able
        // to built filter and that sql can be generated.

        $key = 'filter';
        $processors = [
            $key => ConstraintsProcessor::make()
                ->filters([
                    'id' => NumericFilter::class,
                    'created_at' => DatetimeFilter::make()
                        ->setAllowedDateFormats([
                            DateTimeFormats::RFC3339_ZULU
                        ])
                ])
        ];

        $builder = $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'filter' => [
                    'id' => [
                        'gt' => 2
                    ],
                    'created_at' => [
                        'lte' => '2005-08-15T15:52:01Z',
                    ]
                ]
            ]
        ));

        $built = $builder->build();
        $this->assertTrue($built->has($key), 'Filter was not built');

        // --------------------------------------------------------------- //

        $filters = $built->get($key);
        $this->assertCount(2, $filters);

        // Apply filter and assert that sql can be generated...
        foreach ($filters as $filter) {
            $query = $filter->apply(Category::query());

            $sql = $query->toSql();
            ConsoleDebugger::output($sql);

            $this->assertNotEmpty($sql, 'Query was not built');
        }
    }
}
