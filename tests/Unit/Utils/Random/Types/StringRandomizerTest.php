<?php

namespace Aedart\Tests\Unit\Utils\Random\Types;

use Aedart\Contracts\Utils\Random\StringRandomizer;
use Aedart\Contracts\Utils\Random\Type;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Random\Factory;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * StringRandomizerTest
 *
 * @group utils
 * @group utils-random
 * @group utils-randomizer
 * @group string-randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils\Random\Types
 */
#[Group(
    'utils',
    'utils-random',
    'utils-randomizer',
    'string-randomizer',
)]
class StringRandomizerTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns new randomizer instance
     *
     * @return StringRandomizer
     */
    public function makeRandomizer(): StringRandomizer
    {
        return Factory::make(Type::String);
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
    public function canGetRandomBytes(): void
    {
        $result = $this->makeRandomizer()->bytes(10);

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
    public function canGetRandomBytesFromString(): void
    {
        $result = $this->makeRandomizer()->bytesFromString('abcdefghijklmnopqrstuvwxyz0123456789', 10);

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
    public function canShuffleBytes(): void
    {
        $result = $this->makeRandomizer()->shuffle(implode('', range('a', 'z')));

        ConsoleDebugger::output($result);

        $this->assertIsString($result);
    }
}
