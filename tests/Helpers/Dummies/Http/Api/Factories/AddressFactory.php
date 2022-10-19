<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Factories;

use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Address Factory
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Factories
 */
class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = Address::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'street' => $faker->streetAddress(),
            'postal_code' => $faker->postcode(),
            'city' => $faker->city(),
        ];
    }
}