<?php

namespace Aedart\Tests\Unit\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\NumericRandomizer;
use Aedart\Contracts\Utils\Random\Type;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Random\Factory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * NumericRandomizerTest
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils\Random\Types
 */
#[Group(
    'utils',
    'utils-random',
    'utils-randomizer',
    'numeric-randomizer',
)]
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
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canGetRandomInt(): void
    {
        $result = $this->makeRandomizer()->int(1, 10);

        ConsoleDebugger::output($result);

        $this->assertIsInt($result);
    }

    /**
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canGetNextInt(): void
    {
        $result = $this->makeRandomizer()->nextInt();

        ConsoleDebugger::output($result);

        $this->assertIsInt($result);
    }

    /**
     * @return void
     */
    #[Test]
    public function canGetRandomFloat(): void
    {
        $result = $this->makeRandomizer()->float(0, 1);

        ConsoleDebugger::output($result);

        $this->assertIsFloat($result);
    }

    /**
     * @return void
     *
     * @throws Throwable
     */
    #[Test]
    public function canGetNextFloat(): void
    {
        $result = $this->makeRandomizer()->nextFloat();

        ConsoleDebugger::output($result);

        $this->assertIsFloat($result);
    }
}
