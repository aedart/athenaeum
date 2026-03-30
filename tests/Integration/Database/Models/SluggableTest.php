<?php

namespace Aedart\Tests\Integration\Database\Models;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Database\Models\Category;
use Aedart\Tests\TestCases\Database\DatabaseTestCase;
use Codeception\Attribute\Group;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;

/**
 * SluggableTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Database\Models
 */
#[Group(
    'db',
    'database',
    'db-models',
    'db-sluggable',
)]
class SluggableTest extends DatabaseTestCase
{
    #[Test]
    public function canFindBySlug()
    {
        $slug = 'products';
        $data = [
            'slug' => $slug,
            'name' => 'Products',
            'description' => $this->getFaker()->text()
        ];

        // ------------------------------------------------------- //
        // Create...

        $first = Category::create($data);

        // ------------------------------------------------------- //
        // Find...
        $second = Category::findBySlug($slug);

        $this->assertNotNull($second, 'Failed to find model via slug');
        $this->assertSame($first->id, $second->id, 'Incorrect model found');
    }

    #[Test]
    public function canFindBySlugOrFail()
    {
        $slug = 'products';
        $data = [
            'slug' => $slug,
            'name' => 'Products',
            'description' => $this->getFaker()->text()
        ];

        // ------------------------------------------------------- //
        // Create...

        Category::create($data);

        // ------------------------------------------------------- //
        // Find...
        $second = Category::findBySlugOrFail($slug);
        $this->assertNotNull($second, 'Failed to find model via slug');
    }

    #[Test]
    public function failsWhenUnableToFindBySlug()
    {
        $this->expectException(ModelNotFoundException::class);

        $slug = 'products';
        $data = [
            'slug' => $slug,
            'name' => 'Products',
            'description' => $this->getFaker()->text()
        ];

        // ------------------------------------------------------- //
        // Create...

        Category::create($data);

        // ------------------------------------------------------- //
        // Find... which SHOULD fail
        Category::findBySlugOrFail('unknown');
    }

    /**
     * @see https://github.com/aedart/athenaeum/issues/39
     */
    #[Test]
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

    /**
     * @see https://github.com/aedart/athenaeum/issues/39
     */
    #[Test]
    public function failsCreationWhenAlreadyExists()
    {
        // This is a control test, which should ensure that creation
        // of a new model, with identical slug, will fail.
        // Creation is done via Eloquent's regular create method.

        $this->expectException(QueryException::class);
        $this->expectExceptionMessageMatches('/Integrity constraint violation:/');

        $data = [
            'slug' => 'products',
            'name' => 'Products',
            'description' => $this->getFaker()->text()
        ];

        Category::create($data);

        // This should trigger a unique index violation in the database
        Category::create($data);
    }

    #[Test]
    public function canFindByManySlugs()
    {
        // ------------------------------------------------------- //
        // Create...

        /** @var Category $first */
        $first = Category::create([
            'slug' => 'products',
            'name' => 'Products',
            'description' => $this->getFaker()->text()
        ]);

        /** @var Category $second */
        $second = Category::create([
            'slug' => 'services',
            'name' => 'Services',
            'description' => $this->getFaker()->text()
        ]);

        /** @var Category $third */
        $third = Category::create([
            'slug' => 'contacts',
            'name' => 'Contacts',
            'description' => $this->getFaker()->text()
        ]);

        // ------------------------------------------------------- //
        // Find
        $results = Category::findManyBySlugs([$second->slug, $third->slug]);
        $this->assertTrue($results->isNotEmpty(), 'No results found');
        $this->assertCount(2, $results, 'Incorrect amount of results found');

        ConsoleDebugger::output($results->toArray());

        $a = $results->where('slug', $third->slug)->first();
        $b = $results->where('slug', $second->slug)->first();
        $this->assertSame($second->slug, $b['slug']);
        $this->assertSame($third->slug, $a['slug']);

        $c = $results->where('slug', $first->slug)->first();
        $this->assertNull($c, 'Collection contains unexpected model!');
    }
}
