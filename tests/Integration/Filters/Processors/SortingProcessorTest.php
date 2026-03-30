<?php

namespace Aedart\Tests\Integration\Filters\Processors;

use Aedart\Filters\Processors\SortingProcessor;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * SortProcessorTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters\Processors
 */
#[Group(
    'filters',
    'filters-sorting-processor',
)]
class SortingProcessorTest extends FiltersTestCase
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[Test]
    public function canBuildSearchQuery()
    {
        $key = 'sort';
        $processors = [
            $key => SortingProcessor::make()
                ->sortable([ 'slug', 'name', 'created_at', 'updated_at' ])
                ->defaultSort('slug desc')
        ];

        $builder = $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'sort' => 'slug desc, name asc'
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

        $this->assertStringContainsString('order by', $sql);
    }
}
