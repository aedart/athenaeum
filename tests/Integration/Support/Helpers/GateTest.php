<?php

namespace Aedart\Tests\Integration\Support\Helpers;

use Aedart\Support\Helpers\Auth\Access\GateTrait;

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
class GateTest extends LaravelSupportHelpersTest
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
