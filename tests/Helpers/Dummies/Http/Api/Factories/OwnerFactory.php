<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Factories;

use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Owner Factory
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Factories
 */
class OwnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = Owner::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name()
        ];
    }
}