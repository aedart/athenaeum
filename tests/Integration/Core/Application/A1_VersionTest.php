<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Tests\TestCases\AthenaeumCoreTestCase;

/**
 * A1_VersionTest
 *
 * @group application
 * @group application-a1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class A1_VersionTest extends AthenaeumCoreTestCase
{
    /**
     * @test
     */
    public function hasVersion()
    {
        $this->assertNotEmpty($this->app->version());
    }
}
