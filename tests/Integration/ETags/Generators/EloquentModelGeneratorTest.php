<?php

namespace Aedart\Tests\Integration\ETags\Generators;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\ETags\Generator;
use Aedart\ETags\Exceptions\UnableToGenerateETag;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Illuminate\Database\Eloquent\Model;

/**
 * EloquentModelGeneratorTest
 *
 * @group etags
 * @group etags-generators
 * @group etags-eloquent-model-generator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Generators
 */
class EloquentModelGeneratorTest extends ETagsTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates generator instance
     *
     * @param  array  $options  [optional]
     *
     * @return Generator
     *
     * @throws ProfileNotFoundException
     */
    public function generator(array $options = []): Generator
    {
        return $this->makeGenerator('model', $options);
    }

    /**
     * Makes a new model instance
     *
     * @param  array  $attributes  [optional]
     *
     * @return Model
     */
    public function makeModel(array $attributes = []): Model
    {
        $modelClass = new class extends Model {
            protected $table = 'users';
            protected $fillable = [ 'id' ];
        };

        return new $modelClass($attributes);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     * @throws ETagGeneratorException
     */
    public function failsIfContentIsNotAnEloquentModel(): void
    {
        $this->expectException(UnableToGenerateETag::class);

        $this->generator()->make('something');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     * @throws ProfileNotFoundException
     */
    public function canMakeETagForModel(): void
    {
        $model = $this->makeModel([
            'id' => 1234,
            'updated_at' => now()
        ]);

        $eTag = $this->generator()->make($model);

        ConsoleDebugger::output($eTag);

        $this->assertNotEmpty($eTag->raw());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     * @throws ProfileNotFoundException
     */
    public function canResolveAdditionalAttributes(): void
    {
        $faker = $this->getFaker();

        $model = $this->makeModel([
            'id' => $faker->randomNumber(),
            'updated_at' => now(),
            'name' => $faker->name(),
        ]);

        $eTag = $this
            ->generator([
                'attributes' => [
                    'name',
                    'updated_at'
                ]
            ])
            ->make($model);

        ConsoleDebugger::output($eTag);

        $this->assertNotEmpty($eTag->raw());
    }
}