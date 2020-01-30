<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Math;

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
    public function canGenerateSeed()
    {
        // NOTE: We do not really care about how valid, good or
        // unique the random seed generator is, in this test.
        $result = Math::seed();

        ConsoleDebugger::output($result);

        $this->assertNotEmpty($result);
    }
}
