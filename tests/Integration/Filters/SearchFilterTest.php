<?php

namespace Aedart\Tests\Integration\Filters;

use Aedart\Filters\Query\Filters\BaseSearchQuery;
use Aedart\Filters\Query\Filters\SearchFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;

/**
 * SearchFilterTest
 *
 * @group filters
 * @group filters-search
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters
 */
class SearchFilterTest extends FiltersTestCase
{
    /**
     * @test
     */
    public function canApplyFilter()
    {
        $search = $this->getFaker()->words(3, true);
        $columns = [ 'name', 'description' ];
        $filter = new SearchFilter($search, $columns);

        $query = $filter->apply(Category::query());
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        ConsoleDebugger::output($sql, $bindings);
        //        $this->assertStringContainsString($search, $sql); // Will not work, due to binding values!

        // Bindings
        $this->assertNotEmpty($bindings, 'No bindings set');

        // - Ensure that multiple variations of the search term has been added...
        // See the raw sql output and bindings for details...
        $this->assertGreaterThan(1, count($bindings), 'Insufficient binding values added!');

        // Columns
        foreach ($columns as $column) {
            $this->assertStringContainsString($column, $sql, 'Column not part of search query!');
        }
    }

    /**
     * @test
     *
     * @return void
     */
    public function canApplySearchCallback(): void
    {
        $search = $this->getFaker()->words(3, true);

        $filter = new SearchFilter($search, function ($query, $search) {
            return $query->where('my_column', '>', $search);
        });

        $query = $filter->apply(Category::query());
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        ConsoleDebugger::output($sql, $bindings);

        $this->assertStringContainsString('where (`my_column` > ?)', $sql);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canApplyInvokableSearchQueryInstance(): void
    {
        $search = $this->getFaker()->words(3, true);

        $searchQuery = new class() extends BaseSearchQuery {
            public function __invoke(Builder|EloquentBuilder $query, string $search): Builder|EloquentBuilder
            {
                return $query
                    ->orWhere('name', '=', $search)
                    ->orWhere('owner', '=', $search);
            }
        };

        $filter = new SearchFilter($search, $searchQuery);

        $query = $filter->apply(Category::query());
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        ConsoleDebugger::output($sql, $bindings);

        $this->assertStringContainsString('where (`name` = ? or `owner` = ?)', $sql);
    }
}
