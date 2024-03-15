<?php

namespace Aedart\Tests\Unit\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\ArrayRandomizer;
use Aedart\Contracts\Utils\Random\Type;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Random\Factory;
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
    public function canPickArrayKeys(): void
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
    public function canShuffleArray(): void
    {
        $result = $this->makeRandomizer()->shuffle([ 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5 ]);

        ConsoleDebugger::output($result);

        $this->assertIsArray($result);
    }
}
