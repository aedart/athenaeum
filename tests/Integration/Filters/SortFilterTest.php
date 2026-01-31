<?php

namespace Aedart\Tests\Integration\Filters;

use Aedart\Filters\Query\Filters\BaseSortingQuery;
use Aedart\Filters\Query\Filters\SortFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Codeception\Attribute\Group;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use PHPUnit\Framework\Attributes\Test;

/**
 * SortFilterTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters
 */
#[Group(
    'filters',
    'filters-sort',
)]
class SortFilterTest extends FiltersTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function canBeApplied(): void
    {
        $filter = new SortFilter([
            'slug' => 'desc',
            'name' => 'asc'
        ]);

        $query = $filter->apply(Category::query());
        $sql = $query->toSql();

        ConsoleDebugger::output($sql);
        $this->assertStringContainsString('order by', $sql);
        $this->assertStringContainsString('slug', $sql);
        $this->assertStringContainsString('name', $sql);
        $this->assertStringContainsString('desc', $sql);
        $this->assertStringContainsString('asc', $sql);
    }

    /**
     * @return void
     */
    #[Test]
    public function canApplySortingCallback(): void
    {
        $filter = (new SortFilter([
            'slug' => 'desc',
            'name' => 'asc'
        ]))->withSortingCallback('name', function ($query, $column, $direction) {
            return $query->orderBy("users.{$column}", $direction);
        });

        $query = $filter->apply(Category::query());
        $sql = $query->toSql();

        ConsoleDebugger::output($sql);

        $this->assertStringContainsString('order by', $sql);
        $this->assertStringContainsString('"users"."name" asc', $sql);
    }

    /**
     * @return void
     */
    #[Test]
    public function canApplyInvokableSortingQuery(): void
    {
        $sortingQuery = new class() extends BaseSortingQuery {
            public function __invoke(
                Builder|EloquentBuilder $query,
                string $column,
                string $direction = 'asc'
            ): Builder|EloquentBuilder {
                return $query->orderBy("users.{$column}", $direction);
            }
        };

        $filter = (new SortFilter([
            'slug' => 'desc',
            'age' => 'desc'
        ]))->withSortingCallbacks([
            'age' => $sortingQuery
        ]);

        $query = $filter->apply(Category::query());
        $sql = $query->toSql();

        ConsoleDebugger::output($sql);

        $this->assertStringContainsString('order by', $sql);
        $this->assertStringContainsString('"users"."age" desc', $sql);
    }
}
