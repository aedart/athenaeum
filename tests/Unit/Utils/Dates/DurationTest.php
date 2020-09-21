<?php

namespace Aedart\Tests\Unit\Utils\Dates;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Dates\Duration;

/**
 * DurationTest
 *
 * @group utils
 * @group date
 * @group duration
 *
 * Example: codecept run Unit Utils
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Dates
 */
class DurationTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canInstantiate()
    {
        $duration = new Duration(42);

        $this->assertSame($duration->format("%S"), "42");
    }

}
