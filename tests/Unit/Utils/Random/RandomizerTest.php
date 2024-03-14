<?php

namespace Aedart\Tests\Unit\Utils\Random;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Random\Factory;
use Throwable;

/**
 * RandomizerTest
 *
 * @group utils
 * @group utils-random
 * @group utils-randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils\Random
 */
class RandomizerTest extends UnitTestCase
{
    // NOTE: These tests do NOT verify randomness. Only that API methods can be invoked
    // and return value(s)...

    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    public function canGetRandomBytes(): void
    {
        $result = Factory::make()->bytes(10);

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
    public function canShuffleBytes(): void
    {
        $result = Factory::make()->shuffleBytes(implode('', range('a', 'z')));

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
    public function canGetRandomInt(): void
    {
        $result = Factory::make()->int(1, 10);

        ConsoleDebugger::output($result);

        $this->assertIsInt($result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    public function canGetNextInt(): void
    {
        $result = Factory::make()->nextInt();

        ConsoleDebugger::output($result);

        $this->assertIsInt($result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws Throwable
     */
    public function canPickArrayKeys(): void
    {
        $result = Factory::make()->pickKeys([ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ], 2);

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
    public function canShuffleArray(): void
    {
        $result = Factory::make()->shuffle([ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ]);

        ConsoleDebugger::output($result);

        $this->assertIsArray($result);
    }
}
