<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Factories;

use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Game Factory
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Factories
 */
class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = Game::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'slug' => $faker->unique()->slug(3),
            'name' => 'Game: ' . $faker->text(10),
            'description' => $faker->realText(150),
            'owner_id' => function() {
                return Owner::factory()->create();
            }
        ];
    }
}