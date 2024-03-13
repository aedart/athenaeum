<?php

namespace Aedart\Tests\Integration\Filters;

use Aedart\Filters\Query\Filters\Fields\BelongsToFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Owner;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;

/**
 * BelongsToFilterTest
 *
 * @group filters
 * @group filters-belongs-to
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters
 */
class BelongsToFilterTest extends FiltersTestCase
{
    /**
     * @test
     *
     * @throws \Aedart\Contracts\Database\Query\Exceptions\CriteriaException
     */
    public function canBeApplied()
    {
        $filter = BelongsToFilter::make('id')
            ->setRelation('category');

        $query = $filter->apply(Owner::query());
        $sql = $query->toSql();

        ConsoleDebugger::output($sql);

        // Ensure that "where relation exists" clause has been added...
        $this->assertStringContainsString('where exists (select * from "categories"', $sql);
    }
}
