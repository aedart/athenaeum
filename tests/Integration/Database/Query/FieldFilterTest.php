<?php

namespace Aedart\Tests\Integration\Database\Query;

use Aedart\Contracts\Database\Query\Exceptions\CriteriaException;
use Aedart\Contracts\Database\Query\Exceptions\InvalidOperatorException;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\Helpers\Dummies\Database\Query\Filters\GenericFilter;
use Aedart\Tests\TestCases\Database\DatabaseTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * FieldFilterTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Database\Query
 */
#[Group(
    'db',
    'database',
    'db-filters',
    'db-criteria',
    'db-field-criteria',
)]
class FieldFilterTest extends DatabaseTestCase
{
    #[Test]
    public function canApplyFieldFilter()
    {
        // Create dummy data
        $faker = $this->getFaker();
        Category::create([
            'slug' => $faker->slug(),
            'name' => 'Books',
            'description' => $faker->text()
        ]);

        // ------------------------------------------------------- //

        $result = Category::applyFilters(new GenericFilter('name', '=', 'Books'))->first();

        $this->assertNotNull($result);
        $this->assertSame('Books', $result->name, 'Incorrect result');
    }

    #[Test]
    public function failsWhenFieldIsEmpty()
    {
        $this->expectException(CriteriaException::class);

        new GenericFilter('', '=', 'Books');
    }

    #[Test]
    public function failsWhenOperatorIsUnsupported()
    {
        $this->expectException(InvalidOperatorException::class);

        new GenericFilter('name', '<=>');
    }
}
