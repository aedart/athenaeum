<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Helpers\MethodHelper;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * MethodHelperTest
 *
 * @group utils
 * @group method-helper
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
#[Group(
    'utils',
    'method-helper',
)]
class MethodHelperTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a property name
     *
     * @return string
     */
    public function makePropertyName(): string
    {
        return $this->faker->randomElement([
            'age',
            'width',
            'height',
            'name'
        ]);
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    /**
     * @test
     */
    #[Test]
    public function canMakeGetterName()
    {
        $property = $this->makePropertyName();

        $result = MethodHelper::makeGetterName($property);

        ConsoleDebugger::output($result);

        $this->assertSame('get' . ucfirst($property), $result);
    }

    /**
     * @test
     */
    #[Test]
    public function usesCachedGetterName()
    {
        // As long as test does not fail, it's considered passed.
        $property = $this->makePropertyName();

        $resultA = MethodHelper::makeGetterName($property);
        $resultB = MethodHelper::makeGetterName($property);

        ConsoleDebugger::output($resultA, $resultB);

        $this->assertSame('get' . ucfirst($property), $resultA);
        $this->assertSame($resultA, $resultB);
    }

    /**
     * @test
     */
    #[Test]
    public function canMakeSetterName()
    {
        $property = $this->makePropertyName();

        $result = MethodHelper::makeSetterName($property);

        ConsoleDebugger::output($result);

        $this->assertSame('set' . ucfirst($property), $result);
    }

    /**
     * @test
     */
    #[Test]
    public function usesCachedSetterName()
    {
        // As long as test does not fail, it's considered passed.
        $property = $this->makePropertyName();

        $resultA = MethodHelper::makeSetterName($property);
        $resultB = MethodHelper::makeSetterName($property);

        ConsoleDebugger::output($resultA, $resultB);

        $this->assertSame('set' . ucfirst($property), $resultA);
        $this->assertSame($resultA, $resultB);
    }

    /**
     * @test
     */
    #[Test]
    public function canCallMethod()
    {
        $method = fn ($lastName) => 'James ' . $lastName;

        $result = MethodHelper::callOrReturn($method, ['Bond']);

        ConsoleDebugger::output($result);

        $this->assertSame('James Bond', $result);
    }

    /**
     * @test
     */
    #[Test]
    public function returnsValueIfNotCallable()
    {
        $method = $this->faker->name();

        $result = MethodHelper::callOrReturn($method);

        ConsoleDebugger::output($result);

        $this->assertSame($method, $result);
    }
}
