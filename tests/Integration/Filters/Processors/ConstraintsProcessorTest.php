<?php

namespace Aedart\Tests\Integration\Filters\Processors;

use Aedart\Filters\Processors\ConstraintsProcessor;
use Aedart\Filters\Query\Filters\Fields\NumericFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;

/**
 * ConstraintsProcessorTest
 *
 * @group filters
 * @group filters-constraints-processor
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Filters\Processors
 */
class ConstraintsProcessorTest extends FiltersTestCase
{
    /**
     * @test
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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
                ])
        ];

        $builder = $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'filter' => [
                    'id' => [
                        'gt' => 2
                    ]
                ]
            ]
        ));

        $built = $builder->build();
        $this->assertTrue($built->has($key), 'Filter was not built');

        // --------------------------------------------------------------- //

        $filters = $built->get($key);
        $this->assertCount(1, $filters);

        // Apply filter and assert that sql can be generated...
        $filter = $filters[0];
        $query = $filter->apply(Category::query());

        $sql = $query->toSql();
        ConsoleDebugger::output($sql);

        $this->assertNotEmpty($sql, 'Query was not built');
    }
}
