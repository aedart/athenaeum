<?php

namespace Aedart\Tests\Integration\Redmine;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\Exceptions\RedmineException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Redmine\DummyResource;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * FilterCallbackTest
 *
 * @group redmine
 * @group redmine-resource
 * @group redmine-resource-filter-callback
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine
 */
#[Group(
    'redmine',
    'redmine-resources',
    'redmine-resources-filter-callback'
)]
class FilterCallbackTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws HttpQueryBuilderException
     * @throws Throwable
     */
    #[Test]
    public function canApplyFilterCallback()
    {
        $hasAppliedCallback = false;
        $include = '@something-to-include';

        $request = DummyResource::make()
            ->applyFiltersCallback(function (Builder $request) use (&$hasAppliedCallback, $include) {
                $hasAppliedCallback = true;

                return $request->include($include);
            });

        // ------------------------------------------------- //

        $this->assertTrue($hasAppliedCallback);

        $query = $request->query()->build();
        ConsoleDebugger::output($query);
        $this->assertStringContainsString($include, $query);
    }

    /**
     * @test
     *
     * @throws Throwable
     */
    #[Test]
    public function failsIfCallbackDoesNotReturnValidRequestBuilder()
    {
        $this->expectException(RedmineException::class);

        DummyResource::make()
            ->applyFiltersCallback(function (Builder $request) {
                // Not returning - or returning anything other than
                // a valid request builder SHOULD cause in failure...
            });
    }
}
