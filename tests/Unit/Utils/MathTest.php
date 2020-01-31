<?php

namespace Aedart\Tests\Unit\Utils;

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
     */
    public function canGenerateRandomInt()
    {
        $resultA = Math::randomInt(0, 100);
        $resultB = Math::randomInt(0, 100);
        $resultC = Math::randomInt(0, 100);

        ConsoleDebugger::output($resultA, $resultB, $resultC);

        $this->assertNotEmpty($resultA);
        $this->assertNotEmpty($resultB);
        $this->assertNotEmpty($resultC);
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
}
