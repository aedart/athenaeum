<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * A1_VersionTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
#[Group(
    'application',
    'application-a1',
)]
class A1_VersionTest extends AthenaeumCoreTestCase
{
    #[Test]
    public function hasVersion()
    {
        $this->assertNotEmpty($this->app->version());
    }
}
