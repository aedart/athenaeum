<?php

namespace Aedart\Tests\Integration\Support\Helpers;

use Aedart\Support\Helpers\Auth\Access\GateTrait;
use Aedart\Tests\TestCases\Support\LaravelHelpersTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * GateTest
 *
 * @group laravel
 * @group support
 * @group support-helpers
 * @group support-helpers-auth-gate
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Support\Helpers
 */
#[Group(
    'laravel',
    'support',
    'support-helpers',
    'support-helpers-auth-gate',
)]
class GateTest extends LaravelHelpersTestCase
{
    use GateTrait;

    /**
     * @test
     */
    #[Test]
    public function canObtainGate()
    {
        $gate = $this->getGate();

        $this->assertNotNull($gate);
    }
}
