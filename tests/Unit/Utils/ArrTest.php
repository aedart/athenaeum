<?php


namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Arr;

/**
 * ArrTest
 *
 * @group utils
 * @group array
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
class ArrTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canObtainSingleRandomElement()
    {
        $list = range('a', 'z');

        $result = Arr::randomElement($list);

        ConsoleDebugger::output($result);

        $this->assertTrue(in_array($result, $list));
    }

    /**
     * @test
     */
    public function returnsSameValueWhenSeededWithStaticValue()
    {
        $list = range('a', 'z');

        $seed = 123456;

        $resultA = Arr::randomElement($list, $seed);
        $resultB = Arr::randomElement($list, $seed);
        $resultC = Arr::randomElement($list, $seed);

        ConsoleDebugger::output($resultA, $resultB, $resultC);

        $this->assertSame($resultA, $resultB);
        $this->assertSame($resultA, $resultC);
        $this->assertSame($resultB, $resultC);
    }
}
