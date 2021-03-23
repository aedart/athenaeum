<?php

namespace Aedart\Tests\Integration\Database\Models;

use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Database\DatabaseTestCase;
use Illuminate\Support\Carbon;

/**
 * SluggableTest
 *
 * @group database
 * @group db
 * @group db-models
 * @group db-sluggable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Database\Models
 */
class SluggableTest extends DatabaseTestCase
{
    /**
     * @test
     *
     * @see https://github.com/aedart/athenaeum/issues/39
     */
    public function canFindOrCreateBySlug()
    {
        $slug = 'products';
        $data = [
            'name' => 'Products',
            'description' => $this->getFaker()->text()
        ];

        // ------------------------------------------------------- //
        // Create...

        $first = Category::findOrCreateBySlug($slug, $data);
        $this->assertTrue($first->wasRecentlyCreated, 'First model should had been created');

        // ------------------------------------------------------- //
        // Method should now return already created model instance
        $second = Category::findOrCreateBySlug($slug, $data);
        $this->assertFalse($second->wasRecentlyCreated, 'Second model SHOULD NOT have been created');

        // ------------------------------------------------------- //
        // Check model properties
        $properties = $first->toArray();
        $second = $second->toArray();

        foreach ($properties as $property => $value) {
            $this->assertTrue(isset($second[$property]), "{$property} does not exist in second model");

            if ($value instanceof Carbon) {
                $secondValue = $second[$property];
                $this->assertTrue($value->eq($secondValue), 'Datetime does not appear to match');
                continue;
            }

            $this->assertSame($value, $second[$property], "{$property} does not match in second model");
        }

        // ------------------------------------------------------- //
        // Check all records in database
        //$all = Category::all();
        $this->assertDatabaseCount('categories', 1, 'testing');
    }
}
