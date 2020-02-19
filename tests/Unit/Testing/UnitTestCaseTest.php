<?php

namespace Aedart\Tests\Unit\Testing;

use Aedart\Testing\TestCases\UnitTestCase;

/**
 * UnitTestCaseTest
 *
 * @group testing
 * @group testCase
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Testing
 */
class UnitTestCaseTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canTestSomething()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function hasFakerDependency()
    {
        $value = $this->faker->address;

        $this->assertNotEmpty($value);
    }
}
