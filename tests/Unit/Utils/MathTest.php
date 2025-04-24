<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Contracts\Utils\Random\NumericRandomizer;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Math;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use ValueError;

/**
 * MathTest
 *
 * @group utils
 * @group math
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
#[Group(
    'utils',
    'math',
)]
class MathTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsRandomizer(): void
    {
        $randomizer = Math::randomizer();

        $this->assertInstanceOf(NumericRandomizer::class, $randomizer);
    }

    /**
     * @test
     */
    #[Test]
    public function failsRandomIntWhenInvalidArguments()
    {
        $this->expectException(ValueError::class);

        Math::randomizer()->int(1, -1);
    }

    /**
     * @test
     */
    #[Test]
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
    #[Test]
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
