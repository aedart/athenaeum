<?php

namespace Aedart\Testing\Helpers;

use Aedart\Testing\Exceptions\IncorrectPropertiesAmount;
use Codeception\TestCase\Test;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * Trait Tester
 *
 * <br />
 *
 * Able to test a "getter-setter-trait".
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Helpers
 */
class TraitTester
{
    /**
     * The test-case to use
     *
     * @var TestCase|Test
     */
    protected $testCase;

    /**
     * Trait class path
     *
     * @var string
     */
    protected string $trait;

    /**
     * Name of getter-setter-trait property
     *
     * @var string
     */
    protected ?string $property;

    /**
     * The mocked trait
     *
     * @var MockObject
     */
    protected MockObject $mock;

    /**
     * TraitTester constructor.
     *
     * @param TestCase|Test $testCase
     * @param string $trait Trait class path
     * @param null|string $property [optional]
     *
     * @throws ReflectionException
     */
    public function __construct(TestCase $testCase, string $trait, ?string $property)
    {
        $this->testCase = $testCase;
        $this->trait = $trait;
        $this->property = $property ?? $this->guessProperty($trait);
        $this->mock = $this->makeTraitMock($trait);
    }

    /*****************************************************************
     * Assertions
     ****************************************************************/

    /**
     * Assert getter-setter trait with given values
     *
     * <br />
     *
     * If set or default values are given, method will attempt to
     * guess what data to generate that fulfills argument(s).
     *
     * @see \Aedart\Testing\Helpers\ArgumentFaker::fakeFor
     *
     * @param mixed|null $setValue [optional] Auto generated, if none given
     * @param mixed|null $defaultValue [optional] Auto generated, if none given
     * @param bool $assertDefaultIsNull [optional] If true, then "get-default" will be asserted to
     *                                  return "null" on initial call
     *
     * @throws ReflectionException
     */
    public function assert($setValue = null, $defaultValue = null, bool $assertDefaultIsNull = true)
    {
        $trait = $this->trait;
        $method = $this->setPropertyMethodName();

        $setValue = $setValue ?? ArgumentFaker::fakeFor($trait, $method);
        $defaultValue = $defaultValue ?? ArgumentFaker::fakeFor($trait, $method);

        $this->assertWithValues($setValue, $defaultValue, $assertDefaultIsNull);
    }

    /**
     * Assert getter-setter trait with given values
     *
     * @param mixed $setValue The value to set and obtain
     * @param mixed $defaultValue Custom default value
     * @param bool $assertDefaultIsNull [optional] If true, then "get-default" will be asserted to
     *                                  return "null" on initial call
     *
     * @throws ExpectationFailedException
     */
    public function assertWithValues($setValue, $defaultValue, bool $assertDefaultIsNull = true)
    {
        $mock = $this->mock;

        // Ensures default value is null (by default)
        if ($assertDefaultIsNull) {
            $this->assertDefaultValueIsNull($mock);
        }

        // Ensures that no value is set (by default)
        $this->assertHasNoValue($mock);

        // Ensures that a value can be set and retrieved
        $this->assertCanSetAndGetValue($mock, $setValue);

        // Ensure that a custom defined default value is returned by default,
        // if no other value has been set prior to invoking the `get-property`
        // method.
        $this->assertCustomDefaultValue($this->trait, $defaultValue);
    }

    /**
     * Assert that the default value is `null`, by invoking the trait's
     * `get-default-property` method
     *
     * @param MockObject $mock
     * @param string $method [optional] Method name is guessed if none provided
     * @param string $failMessage [optional]
     *
     * @throws ExpectationFailedException
     */
    public function assertDefaultValueIsNull(
        MockObject $mock,
        ?string $method = null,
        string $failMessage = 'Default value should be null'
    ) {
        $method = $method ?? $this->getDefaultPropertyMethodName();

        ConsoleDebugger::output(sprintf(' testing %s()', $method));

        $this->testCase->assertNull($mock->$method(), $failMessage);
    }

    /**
     * Assert that no value is set, by invoking the trait's
     * `has-property` method
     *
     * @param MockObject $mock
     * @param string $method [optional] Method name is guessed if none provided
     * @param string $failMessage [optional]
     *
     * @throws ExpectationFailedException
     */
    public function assertHasNoValue(
        MockObject $mock,
        ?string $method = null,
        string $failMessage = 'Should not have a value set'
    ) {
        $method = $method ?? $this->hasPropertyMethodName();

        ConsoleDebugger::output(sprintf(' testing %s()', $method));

        $this->testCase->assertFalse($mock->$method(), $failMessage);
    }

    /**
     * Assert that the given value can be set and retrieved again,
     * by invoking the trait's `set-property` and `get-property`
     * methods
     *
     * @param MockObject $mock
     * @param mixed $value
     * @param null|string $setMethod [optional] Method name is guessed if none provided
     * @param null|string $getMethod [optional] Method name is guessed if none provided
     * @param string $failMessage [optional]
     *
     * @throws ExpectationFailedException
     */
    public function assertCanSetAndGetValue(
        MockObject $mock,
        $value,
        ?string $setMethod = null,
        ?string $getMethod = null,
        string $failMessage = 'Incorrect value obtained'
    ) {
        $setMethod = $setMethod ?? $this->setPropertyMethodName();
        $getMethod = $getMethod ?? $this->getPropertyMethodName();

        if (is_object($value)) {
            ConsoleDebugger::output(sprintf(' testing %s(%s)', $setMethod, get_class($value)));
        } else {
            ConsoleDebugger::output(sprintf(' testing %s(%s)', $setMethod, var_export($value, true)));
        }

        $mock->$setMethod($value);

        ConsoleDebugger::output(sprintf(' testing %s()', $getMethod));

        $this->testCase->assertSame($value, $mock->$getMethod(), $failMessage);
    }

    /**
     * Assert that a custom defined default value is returned,
     * when nothing else has been specified, by invoking
     * the `get-default-property` and `get-property` methods
     *
     * @param string $trait Trait Class path
     * @param mixed $defaultValue
     * @param null|string $defaultMethod [optional] Method name is guessed if none provided
     * @param null|string $getMethod [optional] Method name is guessed if none provided
     * @param string $failMessage [optional]
     *
     * @throws ExpectationFailedException
     */
    public function assertCustomDefaultValue(
        string $trait,
        $defaultValue,
        ?string $defaultMethod = null,
        ?string $getMethod = null,
        string $failMessage = 'Incorrect default value returned'
    ) {
        $defaultMethod = $defaultMethod ?? $this->getDefaultPropertyMethodName();
        $getMethod = $getMethod ?? $this->getPropertyMethodName();

        if (is_object($defaultValue)) {
            ConsoleDebugger::output(sprintf(' mocking %s(), must return %s', $defaultMethod, get_class($defaultValue)));
        } else {
            ConsoleDebugger::output(sprintf(' mocking %s(), must return %s', $defaultMethod, var_export($defaultValue, true)));
        }

        $mock = $this->makeTraitMock($trait, [
            $defaultMethod
        ]);

        $mock->expects($this->testCase->any())
            ->method($defaultMethod)
            ->willReturn($defaultValue);

        ConsoleDebugger::output(sprintf(' testing %s()', $getMethod));

        $this->testCase->assertSame($defaultValue, $mock->$getMethod(), $failMessage);
    }

    /*****************************************************************
     * Utilities
     ****************************************************************/

    /**
     * Returns a mock for the given trait
     *
     * @param string $trait Trait class path
     * @param string[] $methods [optional] Methods to be mocked
     *
     * @return MockObject
     */
    public function makeTraitMock(string $trait, array $methods = []): MockObject
    {
        $builder = $this->testCase->getMockBuilder($trait);
        $builder
            ->setMockClassName('')
            ->enableOriginalConstructor()
            ->enableOriginalClone()
            ->enableAutoload()
            ->enableArgumentCloning()
            ->onlyMethods($methods);

        return $builder->getMockForTrait();
    }

    /**
     * Get the trait mock
     *
     * @return MockObject
     */
    public function getTraitMock(): MockObject
    {
        return $this->mock;
    }

    /**
     * Guesses a property name for given trait
     *
     * @param string $trait Trait class path
     *
     * @return string
     *
     * @throws ReflectionException
     * @throws IncorrectPropertiesAmount
     */
    public function guessProperty(string $trait): string
    {
        $reflection = new ReflectionClass($trait);

        $properties = $reflection->getProperties();

        if (count($properties) != 1) {
            throw new IncorrectPropertiesAmount(sprintf(
                'Trait %s contains incorrect properties amount. This helper can only test a single property!',
                $trait
            ));
        }

        return $properties[0]->getName();
    }

    /**
     * Returns the property name, camel-cased
     *
     * @see propertyName()
     *
     * @return string
     */
    public function getPropertyName(): string
    {
        return ucwords($this->property);
    }

    /**
     * Returns the name of a 'set-property' method
     *
     * @see getPropertyName()
     *
     * @return string E.g. setDescription, setName, setId
     */
    public function setPropertyMethodName(): string
    {
        return 'set' . $this->getPropertyName();
    }

    /**
     * Returns the name of a 'get-property' method
     *
     * @see getPropertyName()
     *
     * @return string E.g. getDescription, getName, getId
     */
    public function getPropertyMethodName(): string
    {
        return 'get' . $this->getPropertyName();
    }

    /**
     * Returns the name of a 'has-property' method
     *
     * @see getPropertyName()
     *
     * @return string E.g. hasDescription, hasName, hasId
     */
    public function hasPropertyMethodName(): string
    {
        return 'has' . $this->getPropertyName();
    }

    /**
     * Returns the name of a 'get-default-property' method
     *
     * @see getPropertyName()
     *
     * @return string E.g. getDefaultDescription, getDefaultName, getDefaultId
     */
    public function getDefaultPropertyMethodName(): string
    {
        return 'getDefault' . $this->getPropertyName();
    }
}
