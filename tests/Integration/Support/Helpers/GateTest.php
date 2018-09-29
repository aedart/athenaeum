<?php

namespace Aedart\Tests\Integration\Support\Helpers;

use Aedart\Support\Helpers\Auth\Access\GateTrait;
use Aedart\Tests\TestCases\Support\LaravelHelpersTestCase;

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
class GateTest extends LaravelHelpersTestCase
{
    use GateTrait;

    /**
     * @test
     */
    public function canObtainGate()
    {
        $gate = $this->getGate();

        $this->assertNotNull($gate);
    }
}
