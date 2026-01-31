<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ForwardCallTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-forward-call'
)]
class ForwardCallTest extends RedmineTestCase
{
    #[Test]
    public function forwardsMethodCalls()
    {
        $request = DummyResource::where('version', 'beta');

        // When no expectation raised, and the output is a request builder,
        // then test has passed.
        $this->assertInstanceOf(Builder::class, $request);
    }
}
