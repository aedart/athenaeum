<?php

namespace Aedart\Tests\Unit\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\NumericRandomizer;
use Aedart\Contracts\Utils\Random\Type;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Random\Factory;
use Throwable;

/**
 * NumericRandomizerTest
 *
 * @group utils
 * @group utils-random
 * @group utils-randomizer
 * @group numeric-randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils\Random\Types
 */
class NumericRandomizerTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns new randomizer instance
     *
     * @return NumericRandomizer
     */
    public function makeRandomizer(): NumericRandomizer
    {
        return Factory::make(Type::Numeric);
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
    public function canGetRandomInt(): void
    {
        $result = $this->makeRandomizer()->int(1, 10);

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
        $result = $this->makeRandomizer()->nextInt();

        ConsoleDebugger::output($result);

        $this->assertIsInt($result);
    }
}
