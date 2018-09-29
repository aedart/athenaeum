<?php

namespace Aedart\Testing;

use Aedart\Testing\Helpers\TraitTester;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Getter Setter Trait Tester
 *
 * <br />
 *
 * Offers assertion of "getter-setter-traits".
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing
 */
trait GetterSetterTraitTester
{

    /*****************************************************************
     * Assertions
     ****************************************************************/

    /**
     * Assert all methods in the given `getter-setter` trait, by invoking
     * all methods, specifying and retrieving the given value, as well as
     * mocking a custom value return.
     *
     * <br />
     *
     * If set or default values are given, method will attempt to
     * guess what data to generate that fulfills argument(s).
     *
     * @param string $trait Trait class path
     * @param mixed|null $setValue [optional] Auto generated, if none given
     * @param mixed|null $defaultValue [optional] Auto generated, if none given
     * @param bool $assertDefaultIsNull [optional] If true, then "get-default" will be asserted to
     *                                  return "null" on initial call
     *
     * @throws ReflectionException
     */
    public function assertTraitMethods(
        string $trait,
        $setValue = null,
        $defaultValue = null,
        bool $assertDefaultIsNull = true
    ) : void
    {
        $this->makeTraitTester($trait)->assert($setValue, $defaultValue, $assertDefaultIsNull);
    }

    /**
     * Assert all methods in the given `getter-setter` trait, by invoking
     * all methods, specifying and retrieving the given value, as well as
     * mocking a custom value return.
     *
     * @param string $trait Trait class path
     * @param mixed $setValue
     * @param mixed $defaultValue
     * @param bool $assertDefaultIsNull [optional] If true, then "get-default" will be asserted to
     *                                  return "null" on initial call
     *
     * @throws ReflectionException
     */
    public function assertGetterSetterTraitMethods(
        string $trait,
        $setValue,
        $defaultValue,
        bool $assertDefaultIsNull = true
    ) : void
    {
        $this->makeTraitTester($trait)->assertWithValues($setValue, $defaultValue, $assertDefaultIsNull);
    }

    /*****************************************************************
     * Utilities
     ****************************************************************/

    /**
     * Returns a new Trait Tester
     *
     * @param string $trait Trait class path
     * @param null|string $property [optional] Property name is guessed if none given
     *
     * @return TraitTester
     *
     * @throws ReflectionException
     */
    protected function makeTraitTester(string $trait, ?string $property = null) : TraitTester
    {
        /** @var TestCase $this */
        return new TraitTester($this, $trait, $property);
    }
}
