<?php

namespace Aedart\Tests\Integration\Filters;

use Aedart\Filters\Query\Filters\SearchFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;

/**
 * SearchFilterTest
 *
 * @group filters
 * @group filters-search
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Filters
 */
class SearchFilterTest extends FiltersTestCase
{
    /**
     * @test
     */
    public function canBeApplied()
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
}
