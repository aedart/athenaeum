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

    /**
     * @test
     */
    public function canUnFlatten()
    {
        $source = [
            'player.strength' => 15,
            'player.dexterity' => 22,
            'player.intelligence' => 19
        ];

        $result = Arr::undot($source);
        ConsoleDebugger::output($result);

        $this->assertArrayHasKey('player', $result);
        $this->assertIsArray($result['player']);

        $nested = $result['player'];
        $this->assertArrayHasKey('strength', $nested);
        $this->assertArrayHasKey('dexterity', $nested);
        $this->assertArrayHasKey('intelligence', $nested);
    }
}
