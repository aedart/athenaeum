<?php

namespace Aedart\Tests\Unit\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\ArrayRandomizer;
use Aedart\Contracts\Utils\Random\Type;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Random\Factory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * ArrayRandomizerTest
 *
 * @group utils
 * @group utils-random
 * @group utils-randomizer
 * @group array-randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils\Random\Types
 */
#[Group(
    'utils',
    'utils-random',
    'utils-randomizer',
    'array-randomizer',
)]
class ArrayRandomizerTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns new randomizer instance
     *
     * @return ArrayRandomizer
     */
    public function makeRandomizer(): ArrayRandomizer
    {
        return Factory::make(Type::Array);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    // NOTE: These tests do NOT verify randomness. Only that API methods can be invoked
    // and return value(s)...

    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canPickKeys(): void
    {
        $result = $this->makeRandomizer()->pickKeys([ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ], 2);

        ConsoleDebugger::output($result);

        $this->assertIsArray($result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canPickSingleKey(): void
    {
        $result = $this->makeRandomizer()->pickKey([ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ]);

        ConsoleDebugger::output($result);

        $this->assertIsString($result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canPickValues(): void
    {
        $arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];
        $result = $this->makeRandomizer()->values($arr, 2);

        ConsoleDebugger::output($result);

        foreach ($result as $value) {
            $this->assertTrue(in_array($value, $arr));
        }
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canPickValuesAndPreserveKeys(): void
    {
        $arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];
        $result = $this->makeRandomizer()->values($arr, 2, true);

        ConsoleDebugger::output($result);

        foreach ($result as $key => $value) {
            $this->assertTrue(in_array($value, $arr), 'value does not exist');
            $this->assertArrayHasKey($key, $arr, 'key does not exist');
        }
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canPickSingleValue(): void
    {
        $arr = [ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ];
        $result = $this->makeRandomizer()->value($arr);

        ConsoleDebugger::output($result);

        $this->assertTrue(in_array($result, $arr));
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canShuffle(): void
    {
        $result = $this->makeRandomizer()->shuffle([ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ]);

        ConsoleDebugger::output($result);

        $this->assertIsArray($result);
    }
}
