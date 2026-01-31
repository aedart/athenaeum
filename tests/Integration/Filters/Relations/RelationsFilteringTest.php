<?php

namespace Aedart\Tests\Integration\Filters\Relations;

use Aedart\Contracts\Database\Query\Exceptions\CriteriaException;
use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Filters\Query\Filters\Fields\BelongsToFilter;
use Aedart\Filters\Query\Filters\SortFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * RelationsFilteringTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters\Relations
 */
#[Group(
    'filters',
    'filters-relations-filtering',
)]
class RelationsFilteringTest extends FiltersTestCase
{
    /**
     * @return void
     *
     * @throws CriteriaException
     */
    #[Test]
    public function canApplyLogicalOrConstraints(): void
    {
        $filters = [
            BelongsToFilter::make('id', 'eq', 25, FieldCriteria::AND)
                ->setRelation('restrictedOwner'),
            BelongsToFilter::make('id', 'is_null', null, FieldCriteria::OR)
                ->setRelation('restrictedOwner'),
            new SortFilter([ 'restricted_to_owner_id' => 'desc' ])
        ];

        // Select products that belong to category, where product's owner is either a specific
        // value or no owner set...

        $category = new Category();
        $category->id = 150;

        $query = $category
            ->products()
            ->applyFilters($filters);
        //->dd();

        $sql = $query->toSql();

        ConsoleDebugger::output($sql);

        // Ensure that "where relation exists" clause has been added...
        $this->assertStringContainsString('and (exists (select * from "owners" where "products"."restricted_to_owner_id" = "owners"."id" and "id" = ?) or not exists (select * from "owners" where "products"."restricted_to_owner_id" = "owners"."id"))', $sql);
        $this->assertStringContainsString('order by "restricted_to_owner_id" desc', $sql);
    }
}
