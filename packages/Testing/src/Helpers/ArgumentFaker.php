<?php

namespace Aedart\Testing\Helpers;

use Closure;
use DateTime;
use Faker\Factory;
use Faker\Generator;
use Mockery as m;
use Mockery\MockInterface;
use ReflectionException;
use ReflectionMethod;

/**
 * Argument Faker
 *
 * Offers various faker utilities.
 *
 * @see \Faker\Generator
 * @see \Mockery
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Helpers
 */
class ArgumentFaker
{
    /**
     * Fakes a value for the given method's arguments
     *
     * Able to generate fake data for scalar types and mocks
     * for objects, if arguments are type-hinted
     *
     * @param string $target Class path
     * @param string $method
     * @param Generator|null $faker [optional] If none given, a generator is automatically created
     *
     * @return mixed
     *
     * @throws ReflectionException
     */
    public static function fakeFor(string $target, string $method, Generator|null $faker = null): mixed
    {
        $faker = $faker ?? static::makeFakerGenerator();

        $reflectionMethod = new ReflectionMethod($target, $method);
        $parameters = $reflectionMethod->getParameters();

        $output = [];
        foreach ($parameters as $parameter) {
            // Create a mock as "faked" argument, if needed
            $type = $parameter->getType();
            if (isset($type) && !$type->isBuiltin()) {
                $output[] = static::makeMockFor($type->getName());
                continue;
            }

            // Attempt to fake argument for type primitive type
            if (isset($type) && $type->isBuiltin()) {
                $output[] = static::fakeForType($type->getName(), $faker);
                continue;
            }

            // Otherwise, we request 'null' as a type, which is the same as
            // for a string, in this case...
            $output[] = static::fakeForType('null', $faker);
        }

        if (count($output) == 1) {
            return $output[0];
        }

        return $output;
    }

    /**
     * Generates a dummy value for the given type
     *
     * @param string $type array, bool, float, int, string, or null.
     * @param Generator|null $faker [optional] If none given, a generator is automatically created
     *
     * @return string|Closure|int|bool|array|float Returns a string for "null" type
     */
    public static function fakeForType(string $type, Generator|null $faker = null): string|Closure|int|bool|array|float
    {
        $faker = $faker ?? static::makeFakerGenerator();

        return match ($type) {
            'int', 'integer' => $faker->randomNumber(),
            'bool', 'boolean' => $faker->boolean(),
            'float' => $faker->randomFloat(),
            'array' => $faker->randomElements(),
            'callable' => fn () => true,
            'string', 'null' => $faker->name(),
            default => $faker->name()
        };
    }

    /**
     * Returns a mock for the given target
     *
     * @param string $target Class path
     *
     * @return MockInterface
     */
    public static function makeMockFor(string $target): MockInterface
    {
        // Handle special case - DateTimeInterface
        $resolved = match ($target) {
            'DateTimeInterface' => DateTime::class,
            default => $target
        };

        return m::mock($resolved);
    }

    /**
     * Returns a new instance of a Faker Generator
     *
     * @param string $locale [optional]
     *
     * @return Generator
     */
    public static function makeFakerGenerator(string $locale = Factory::DEFAULT_LOCALE): Generator
    {
        return Factory::create($locale);
    }
}
