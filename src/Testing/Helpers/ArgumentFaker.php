<?php

namespace Aedart\Testing\Helpers;

use Faker\Factory;
use Faker\Generator;
use \Mockery as m;
use Mockery\MockInterface;
use ReflectionMethod;

/**
 * Argument Faker
 *
 * <br />
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
     * @return array|mixed
     *
     * @throws \ReflectionException
     */
    static public function fakeFor($target, string $method, ?Generator $faker = null)
    {
        $faker = $faker ?? static::makeFakerGenerator();

        $reflectionMethod = new ReflectionMethod($target, $method);
        $parameters = $reflectionMethod->getParameters();

        $output = [];
        foreach ($parameters as $parameter){

            // Create a mock as "faked" argument, if needed
            $typeClass = $parameter->getClass ();
            if(isset($typeClass)){
                $output[] = static::makeMockFor($typeClass->getName());
                continue;
            }

            // Otherwise, attempt to fake argument for type
            $type = (string) $parameter->getType();
            $output[] = static::fakeForType($type, $faker);
        }

        if(count($output) == 1){
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
     * @return array|bool|float|int|string Returns a string for "null" type
     */
    static public function fakeForType(string $type, ?Generator $faker = null)
    {
        $faker = $faker ?? static::makeFakerGenerator();

        switch (strtolower($type)){

            case 'string':
                return $faker->name;

            case 'int':
            case 'integer':
                return $faker->randomNumber();

            case 'bool':
            case 'boolean':
                return $faker->boolean();

            case 'float':
                return $faker->randomFloat();

            case 'array':
                return $faker->randomElements();

            case 'callable':
                return function(){};

            case 'null';
            default:
                return $faker->name;
        }
    }

    /**
     * Returns a mock for the given target
     *
     * @param string $target Class path
     *
     * @return MockInterface
     */
    static public function makeMockFor(string $target) : MockInterface
    {
        return m::mock($target);
    }

    /**
     * Returns a new instance of a Faker Generator
     *
     * @param string $locale [optional]
     *
     * @return Generator
     */
    static public function makeFakerGenerator(string $locale = Factory::DEFAULT_LOCALE) : Generator
    {
        return Factory::create($locale);
    }
}
