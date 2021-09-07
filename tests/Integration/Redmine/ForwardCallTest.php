<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * ForwardCallTest
 *
 * @group redmine
 * @group redmine-resource
 * @group redmine-resource-forward-call
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Redmine
 */
class ForwardCallTest extends RedmineTestCase
{
    /**
     * @test
     */
    public function forwardsMethodCalls()
    {
        $request = DummyResource::where('version', 'beta');

        // When no expectation raised, and the output is a request builder,
        // then test has passed.
        $this->assertInstanceOf(Builder::class, $request);
    }
}
