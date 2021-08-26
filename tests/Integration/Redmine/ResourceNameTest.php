<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * RedmineResourceTest
 *
 * @group redmine
 * @group redmine-resource
 * @group redmine-resource-name
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine
 */
class ResourceNameTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canObtainResourceName()
    {
        $name = $this->makeDummyResource()->resourceName();

        $this->assertSame('dummies', $name);
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function canObtainNameInSingularForm()
    {
        $name = $this->makeDummyResource()->resourceNameSingular();

        $this->assertSame('dummy', $name);
    }
}
