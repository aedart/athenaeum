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

    // TODO: Implement this..
    public function assertTraitMethods(string $trait, $setValue = null, $defaultValue = null)
    {
        $this->makeTraitTester($trait)->assert($setValue, $defaultValue);
    }

    /**
     * Assert all methods in the given `getter-setter` trait, by invoking
     * all methods, specifying and retrieving the given value, as well as
     * mocking a custom value return.
     *
     * @param string $trait Trait class path
     * @param mixed $setValue
     * @param mixed $defaultValue
     *
     * @throws ReflectionException
     */
    public function assertGetterSetterTraitMethods(string $trait, $setValue, $defaultValue)
    {
        $this->makeTraitTester($trait)->assertWithValues($setValue, $defaultValue);
    }

    // TODO: Needs improvement
    public function assertTraitCompatibility(string $trait, string $interface)
    {
        $id = 'GstDummy_' . str_replace('.', '_', microtime(true));

        $template = "class {$id} implements {$interface} { use {$trait}; }";

        // PHP will automatically fail if the trait contains
        // less or incorrect interface defined methods.
        // This may not be the best way of testing this - but it works.
        // Future versions will improve on this, and allow for none-blocking failures.
        // --> PHP 7's Anonymous classes could be a good an alternative.
        eval($template);

        /** @var TestCase $this */
        $this->assertTrue(true);
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
