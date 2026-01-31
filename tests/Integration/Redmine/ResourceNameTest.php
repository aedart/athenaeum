<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * RedmineResourceTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-name'
)]
class ResourceNameTest extends RedmineTestCase
{
    /**
     * @throws Throwable
     */
    #[Test]
    public function canObtainResourceName()
    {
        $name = $this->makeDummyResource()->resourceName();

        $this->assertSame('dummies', $name);
    }

    /**
     * @throws Throwable
     */
    #[Test]
    public function canObtainNameInSingularForm()
    {
        $name = $this->makeDummyResource()->resourceNameSingular();

        $this->assertSame('dummy', $name);
    }
}
