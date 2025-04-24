<?php

namespace Aedart\Tests\Unit\Testing;

use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * UnitTestCaseTest
 *
 * @group testing
 * @group testCase
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Testing
 */
#[Group(
    'testing',
    'testCase',
)]
class UnitTestCaseTest extends UnitTestCase
{
    /**
     * @test
     */
    #[Test]
    public function canTestSomething()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    #[Test]
    public function hasFakerDependency()
    {
        $value = $this->faker->address();

        $this->assertNotEmpty($value);
    }
}
