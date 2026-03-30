<?php

namespace Aedart\Tests\Integration\Filters;

use Aedart\Filters\Query\Filters\Fields\BelongsToFilter;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Owner;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Codeception\Attribute\Group;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

/**
 * BelongsToFilterTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters
 */
#[Group(
    'filters',
    'filters-belongs-to',
)]
class BelongsToFilterTest extends FiltersTestCase
{
    /**
     * @throws \Aedart\Contracts\Database\Query\Exceptions\CriteriaException
     */
    #[Test]
    public function canBeApplied(): void
    {
        $filter = BelongsToFilter::make('id')
            ->setRelation('category');

        $query = $filter->apply(Owner::query());
        $sql = $query->toSql();

        ConsoleDebugger::output($sql);

        // Ensure that "where relation exists" clause has been added...
        $this->assertStringContainsString('where exists (select * from "categories"', $sql);
    }

    #[Test]
    public function failsWhenIntegerExpectedAndIncorrectValueGiven(): void
    {
        $this->expectException(InvalidArgumentException::class);

        // By default
        $filter = BelongsToFilter::make('id')
            ->setRelation('category')
            ->setValue('my incorrect category id');
    }

    #[Test]
    public function failsWhenStringExpectedAndIncorrectValueGiven(): void
    {
        $this->expectException(InvalidArgumentException::class);

        // By default
        $filter = BelongsToFilter::make('id')
            ->setRelation('category')
            ->usingStringValue()
            ->setValue(123456);
    }
}
