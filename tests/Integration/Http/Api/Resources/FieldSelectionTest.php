<?php

namespace Aedart\Tests\Integration\Http\Api\Resources;

use Aedart\Contracts\Http\Api\SelectedFieldsCollection as SelectedFieldsCollectionInterface;
use Aedart\Http\Api\Resources\SelectedFieldsCollection;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\AlternativeGameResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;
use Aedart\Tests\TestCases\Http\ApiResourcesTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;

/**
 * FieldSelectionTest
 *
 * @group http-api
 * @group api-resource
 * @group api-resource-field-selection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Api\Resources
 */
#[Group(
    'http-api',
    'api-resource',
    'api-resource-field-selection',
)]
class FieldSelectionTest extends ApiResourcesTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    public function outputsAllFieldsWhenNoSelectionFieldsRequested(): void
    {
        $faker = $this->getFaker();
        $data = [
            'slug' => $faker->slug(3),
            'name' => $faker->text(25),
            'description' => $faker->realText(100),
            'created_at' => now()->subDays($faker->randomDigitNotNull),
            'updated_at' => now()->subMinutes($faker->randomDigitNotNull),
            'deleted_at' => now()
        ];

        $resource = new GameResource(new Game($data));

        // -------------------------------------------------------------------- //

        $payload = $resource->toArray(Request::create('something'));

        ConsoleDebugger::output($payload);

        // -------------------------------------------------------------------- //

        $keys = array_keys($data);
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $payload);
        }
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    #[Test]
    public function outputsOnlySelectedFields(): void
    {
        $faker = $this->getFaker();
        $data = [
            'slug' => $faker->slug(3),
            'name' => $faker->text(25),
            'description' => $faker->realText(100),
            'created_at' => now()->subDays($faker->randomDigitNotNull),
            'updated_at' => now()->subMinutes($faker->randomDigitNotNull),
            'deleted_at' => now()
        ];

        $resource = new GameResource(new Game($data));

        // -------------------------------------------------------------------- //

        $select = [ 'slug', 'name' ];
        $payload = $resource->onlySelected(
            $resource->formatPayload(Request::create('something')),
            $select
        );

        ConsoleDebugger::output($payload);

        // -------------------------------------------------------------------- //

        // Selected
        foreach ($select as $key) {
            $this->assertArrayHasKey($key, $payload);
        }
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    #[Test]
    public function canSelectFieldUsingDotNotation(): void
    {
        $faker = $this->getFaker();
        $data = [
            'slug' => $faker->slug(3),
            'name' => $faker->text(25),
            'description' => $faker->realText(100),
            'created_at' => now()->subDays($faker->randomDigitNotNull),
            'updated_at' => now()->subMinutes($faker->randomDigitNotNull),
            'deleted_at' => now()
        ];

        $resource = new AlternativeGameResource(new Game($data));

        // -------------------------------------------------------------------- //

        $select = [ 'slug', 'timestamps.created_at' ];
        $payload = $resource->onlySelected(
            $resource->formatPayload(Request::create('something')),
            $select
        );

        ConsoleDebugger::output($payload);

        // -------------------------------------------------------------------- //

        // Selected
        $this->assertArrayHasKey('slug', $payload);
        $this->assertArrayHasKey('timestamps', $payload);
        $this->assertArrayHasKey('created_at', $payload['timestamps']);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    #[Test]
    public function failsWhenRequestedFieldsDoNotExist(): void
    {
        $noneExistingKey = 'none-existing.key.id';

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Field {$noneExistingKey} does not exist");

        $faker = $this->getFaker();
        $data = [
            'slug' => $faker->slug(3),
            'name' => $faker->text(25),
            'description' => $faker->realText(100),
            'created_at' => now()->subDays($faker->randomDigitNotNull),
            'updated_at' => now()->subMinutes($faker->randomDigitNotNull),
            'deleted_at' => now()
        ];

        $resource = new GameResource(new Game($data));

        // -------------------------------------------------------------------- //

        $select = [ 'slug', 'deleted_at', $noneExistingKey ];
        $resource->onlySelected(
            $resource->formatPayload(Request::create('something')),
            $select
        );
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ValidationException
     */
    #[Test]
    public function obtainsRequestedFieldsFromSelectedFieldsCollection(): void
    {
        $faker = $this->getFaker();
        $data = [
            'slug' => $faker->slug(3),
            'name' => $faker->text(25),
            'description' => $faker->realText(100),
            'created_at' => now()->subDays($faker->randomDigitNotNull),
            'updated_at' => now()->subMinutes($faker->randomDigitNotNull),
            'deleted_at' => now()
        ];

        $resource = new GameResource(new Game($data));

        // -------------------------------------------------------------------- //
        // Bind selected fields collection

        $select = [ 'name', 'updated_at' ];
        IoCFacade::singleton(SelectedFieldsCollectionInterface::class, function () use ($select) {
            return new SelectedFieldsCollection($select);
        });

        // -------------------------------------------------------------------- //

        $payload = $resource->toArray(Request::create('something'));

        ConsoleDebugger::output($payload);

        // -------------------------------------------------------------------- //

        // Selected
        foreach ($select as $key) {
            $this->assertArrayHasKey($key, $payload);
        }

        // Cleanup
        IoCFacade::forgetInstance(SelectedFieldsCollectionInterface::class);
    }
}
