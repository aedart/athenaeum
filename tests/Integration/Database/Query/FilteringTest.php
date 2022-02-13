<?php

namespace Aedart\Tests\Integration\Database\Query;

use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\Helpers\Dummies\Database\Query\Filters\CategoryNameFilter;
use Aedart\Tests\Helpers\Dummies\Database\Query\Filters\CategorySlugFilter;
use Aedart\Tests\Helpers\Dummies\Database\Query\Filters\OptionalCategoryDescFilter;
use Aedart\Tests\TestCases\Database\DatabaseTestCase;
use Aedart\Utils\Str;

/**
 * FilteringTest
 *
 * @group database
 * @group db
 * @group db-filters
 * @group db-criteria
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Database\Query
 */
class FilteringTest extends DatabaseTestCase
{
    /**
     * @test
     */
    public function canApplySingleFilter()
    {
        // Create dummy data
        $faker = $this->getFaker();
        Category::create([
            'slug' => $faker->slug(),
            'name' => 'Products',
            'description' => $faker->text()
        ]);

        // ------------------------------------------------------- //

        $result = Category::applyFilters(new CategoryNameFilter('Products'))->first();

        $this->assertNotNull($result);
        $this->assertSame('Products', $result->name, 'Incorrect result');
    }

    /**
     * @test
     */
    public function canApplyMultipleFilters()
    {
        // Create dummy data
        $faker = $this->getFaker();
        Category::create([
            'slug' => $faker->slug(),
            'name' => 'Products',
            'description' => $faker->text()
        ]);

        Category::create([
            'slug' => 'special-products',
            'name' => 'Products',
            'description' => $faker->text()
        ]);

        Category::create([
            'slug' => $faker->slug(),
            'name' => 'Other',
            'description' => $faker->text()
        ]);

        // ------------------------------------------------------- //

        $result = Category::applyFilters([
            new CategoryNameFilter('Products'),
            new CategorySlugFilter('special-products')
        ])->first();

        $this->assertNotNull($result);
        $this->assertSame('Products', $result->name, 'Incorrect name');
        $this->assertSame('special-products', $result->slug, 'Incorrect slug');
    }

    /**
     * @test
     */
    public function skipsInapplicableFilters()
    {
        // Create dummy data
        $faker = $this->getFaker();
        Category::create([
            'slug' => $faker->slug(),
            'name' => 'Products',
            'description' => $faker->text()
        ]);

        $desc = 'lorum lipsum esta buno';
        Category::create([
            'slug' => $faker->slug(),
            'name' => 'Products',
            'description' => $desc
        ]);

        // ------------------------------------------------------- //

        $result = Category::applyFilters([
            new CategoryNameFilter('Products'),
            new OptionalCategoryDescFilter('lipsum esta', false)
        ])->first();

        $this->assertNotNull($result);
        $this->assertNotTrue(Str::contains($result->description, $desc), 'Incorrect filter was applied');
    }
}
