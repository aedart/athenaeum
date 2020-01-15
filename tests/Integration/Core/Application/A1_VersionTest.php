<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Tests\TestCases\AthenaeumAppTestCase;

/**
 * A1_VersionTest
 *
 * @group application
 * @group application-a1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class A1_VersionTest extends AthenaeumAppTestCase
{
    /**
     * @test
     */
    public function hasVersion()
    {
        $this->assertNotEmpty($this->app->version());
    }
}
