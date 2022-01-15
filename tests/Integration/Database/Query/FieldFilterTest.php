<?php

namespace Aedart\Tests\Integration\Database\Query;

use Aedart\Contracts\Database\Query\Exceptions\CriteriaException;
use Aedart\Contracts\Database\Query\Exceptions\InvalidOperatorException;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\Helpers\Dummies\Database\Query\Filters\GenericFilter;
use Aedart\Tests\TestCases\Database\DatabaseTestCase;

/**
 * FieldFilterTest
 *
 * @group database
 * @group db
 * @group db-filters
 * @group db-criteria
 * @group db-field-criteria
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Database\Query
 */
class FieldFilterTest extends DatabaseTestCase
{
    /**
     * @test
     */
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

    /**
     * @test
     */
    public function failsWhenFieldIsEmpty()
    {
        $this->expectException(CriteriaException::class);

        new GenericFilter('', '=', 'Books');
    }

    /**
     * @test
     */
    public function failsWhenOperatorIsUnsupported()
    {
        $this->expectException(InvalidOperatorException::class);

        new GenericFilter('name', '<=>');
    }
}
