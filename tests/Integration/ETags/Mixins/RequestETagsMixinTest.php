<?php

namespace Aedart\Tests\Integration\ETags\Mixins;

use Aedart\Contracts\ETags\Collection;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Illuminate\Http\Request;

/**
 * RequestETagsMixinTest
 *
 * @group etags
 * @group etags-mixins
 * @group request-etags-mixin
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Mixins
 */
class RequestETagsMixinTest extends ETagsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function hasInstalledMixinInRequest(): void
    {
        $this->assertTrue(Request::hasMacro('etagsFrom'), 'etagsFrom not installed');
        $this->assertTrue(Request::hasMacro('ifMatchEtags'), 'ifMatchEtags not installed');
        $this->assertTrue(Request::hasMacro('ifNoneMatchEtags'), 'ifNoneMatchEtags not installed');
    }

    /**
     * @test
     *
     * @return void
     */
    public function requestHeadersControl(): void
    {
        // This test is more or less just for the sake of debugging.
        // If it does not fail, then test is a pass...

        $request = $this->createRequestWithEtags(
            ifMatch: 'W/"8741", "8920"',
            ifNoneMatch: '"1234", "aibb4hr", W/"9876"'
        );

        ConsoleDebugger::output([
            'If-Match' => $request->header('If-Match'),
            'If-None-Match' => $request->header('If-None-Match'),
            'etags (via Symfony)' => $request->getETags(),
            'Etags (from If-Match)' => optional($request->ifMatchEtags())->toArray(),
            'Etags (from If-None-Match)' => optional($request->ifNoneMatchEtags())->toArray(),
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canGetIfMatchEtags(): void
    {
        $request = $this->createRequestWithEtags(
            ifMatch: '"8741", "8920"'
        );

        /** @var Collection $ifMatchEtags */
        $ifMatchEtags = $request->ifMatchEtags();

        /** @var Collection $ifNoneMatchEtags */
        $ifNoneMatchEtags = $request->ifNoneMatchEtags();

        $this->assertInstanceOf(Collection::class, $ifMatchEtags, 'If-Match etags not a collection');
        $this->assertInstanceOf(Collection::class, $ifNoneMatchEtags, 'If-None-Match etags not a collection');

        ConsoleDebugger::output([
            'If-Match Etags' => $ifMatchEtags->toString(),
            'If-None-Match Etags' => $ifNoneMatchEtags->toString(),
        ]);

        $this->assertTrue($ifMatchEtags->isNotEmpty(), 'If-Match collection does not contain any etags');
        $this->assertTrue($ifNoneMatchEtags->isEmpty(), 'If-None-Match collection should NOT have any etags');

        $this->assertTrue($ifMatchEtags->contains('"8920"', true), 'Collection should contain etag');
    }

    /**
     * @test
     *
     * @return void
     */
    public function canGetIfNoneMatchEtags(): void
    {
        $request = $this->createRequestWithEtags(
            ifNoneMatch: 'W/"1234", W/"aibb4hr", W/"9876"'
        );

        /** @var Collection $ifMatchEtags */
        $ifMatchEtags = $request->ifMatchEtags();

        /** @var Collection $ifNoneMatchEtags */
        $ifNoneMatchEtags = $request->ifNoneMatchEtags();

        $this->assertInstanceOf(Collection::class, $ifMatchEtags, 'If-Match etags not a collection');
        $this->assertInstanceOf(Collection::class, $ifNoneMatchEtags, 'If-None-Match etags not a collection');

        ConsoleDebugger::output([
            'If-Match Etags' => $ifMatchEtags->toString(),
            'If-None-Match Etags' => $ifNoneMatchEtags->toString(),
        ]);

        $this->assertTrue($ifMatchEtags->isEmpty(), 'If-Match collection should NOT have any etags');
        $this->assertTrue($ifNoneMatchEtags->isNotEmpty(), 'If-None-Match collection does not contain any etags');

        $this->assertTrue($ifNoneMatchEtags->contains('W/"9876"'), 'Collection should contain etag');
    }
}