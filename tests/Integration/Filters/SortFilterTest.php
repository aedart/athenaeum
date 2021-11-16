<?php

namespace Aedart\Tests\Integration\Filters;

use Aedart\Filters\Query\Filters\SortFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;

/**
 * SortFilterTest
 *
 * @group filters
 * @group filters-sort
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Filters
 */
class SortFilterTest extends FiltersTestCase
{
    /**
     * @test
     */
    public function canBeApplied()
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
}
