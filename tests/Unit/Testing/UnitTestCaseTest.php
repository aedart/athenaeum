<?php

namespace Aedart\Tests\Unit\Testing;

use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * UnitTestCaseTest
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
    #[Test]
    public function canTestSomething()
    {
        $this->assertTrue(true);
    }

    #[Test]
    public function hasFakerDependency()
    {
        $value = $this->faker->address();

        $this->assertNotEmpty($value);
    }
}
