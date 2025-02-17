<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Contracts\Utils\Random\NumericRandomizer;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Math;
use RuntimeException;

/**
 * MathTest
 *
 * @group utils
 * @group math
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
class MathTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function returnsRandomizer(): void
    {
        $randomizer = Math::randomizer();

        $this->assertInstanceOf(NumericRandomizer::class, $randomizer);
    }

    /**
     * @test
     */
    public function failsRandomIntWhenInvalidArguments()
    {
        $this->expectException(RuntimeException::class);

        Math::randomInt(1, -1);
    }

    /**
     * @test
     */
    public function canGenerateSeed()
    {
        // NOTE: We do not really care about how valid, good or
        // unique the random seed generator is, in this test.
        $result = Math::seed();

        ConsoleDebugger::output($result);

        $this->assertNotEmpty($result);
    }

    /**
     * @test
     */
    public function canApplySeed()
    {
        $seed = 123456;
        $list = ['a', 'b', 'c', 'd'];

        Math::applySeed($seed);
        $a = array_rand($list, 1);
        $resultA = $list[$a];

        Math::applySeed($seed);
        $b = array_rand($list, 1);
        $resultB = $list[$b];

        Math::applySeed($seed);
        $c = array_rand($list, 1);
        $resultC = $list[$c];

        ConsoleDebugger::output($resultA, $resultB, $resultC);

        $this->assertSame($resultA, $resultB);
        $this->assertSame($resultA, $resultC);
        $this->assertSame($resultB, $resultC);
    }
}
