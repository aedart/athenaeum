<?php

namespace Aedart\Tests\Integration\Filters\Processors;

use Aedart\Filters\Processors\SearchProcessor;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Codeception\Attribute\Group;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;

/**
 * SearchProcessorTest
 *
 * @group filters
 * @group filters-search-processor
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters\Processors
 */
#[Group(
    'filters',
    'filters-search-processor',
)]
class SearchProcessorTest extends FiltersTestCase
{
    /**
     * @test
     *
     * @throws ValidationException
     */
    #[Test]
    public function canBuildSearchQuery()
    {
        $key = 'search';
        $processors = [
            $key => SearchProcessor::make()
                ->columns(['name', 'description'])
        ];

        $builder = $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'search' => 'Lina Hollands'
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

    /**
     * @test
     *
     * @throws ValidationException
     */
    #[Test]
    public function canSearchForZero()
    {
        $key = 'search';
        $processors = [
            $key => SearchProcessor::make()
                ->columns(['name', 'description'])
        ];

        $builder = $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'search' => '0'
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

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    #[Test]
    public function canSearchUsingCustomCallback(): void
    {
        $key = 'search';
        $processors = [
            $key => SearchProcessor::make()
                ->columns(function ($query, $search) {
                    return $query->where('my_column', '=', $search);
                })
        ];

        $builder = $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'search' => 'Lina Hollands'
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
        $this->assertStringContainsString('where ("my_column" = ?)', $sql);
    }
}
