<?php

namespace Aedart\Tests\Integration\ETags\Mixins;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Codeception\Attribute\Group;
use DateTimeInterface;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
#[Group(
    'etags',
    'etags-mixins',
    'request-etags-mixin'
)]
class RequestETagsMixinTest extends ETagsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function hasInstalledMixinInRequest(): void
    {
        $this->assertTrue(Request::hasMacro('etagsFrom'), 'etagsFrom not installed');
        $this->assertTrue(Request::hasMacro('ifMatchEtags'), 'ifMatchEtags not installed');
        $this->assertTrue(Request::hasMacro('ifNoneMatchEtags'), 'ifNoneMatchEtags not installed');

        $this->assertTrue(Request::hasMacro('ifRangeEtagOrDate'), 'ifRangeEtagOrDate not installed');
        $this->assertTrue(Request::hasMacro('hasIfRangeHeaders'), 'hasIfRangeHeaders not installed');

        $this->assertTrue(Request::hasMacro('httpDateFrom'), 'httpDateFrom not installed');
        $this->assertTrue(Request::hasMacro('ifModifiedSinceDate'), 'ifModifiedSinceDate not installed');
        $this->assertTrue(Request::hasMacro('ifUnmodifiedSinceDate'), 'ifUnmodifiedSinceDate not installed');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function requestHeadersControl(): void
    {
        // This test is more or less just for the sake of debugging.
        // If it does not fail, then test is a pass...

        $request = $this->createRequest(
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
    #[Test]
    public function doesNotFailWhenNullEtagHeaderValueReceived(): void
    {
        // This is really an edge case, where somehow null is set as value
        // for a header...
        $request = Request::create('/test', 'GET', [], [], [], [
            'HTTP_IF_MATCH' => null
        ]);

        /** @var Collection $ifMatchEtags */
        $ifMatchEtags = $request->etagsFrom('If-Match');

        $this->assertInstanceOf(Collection::class, $ifMatchEtags, 'If-Match etags not a collection');
        $this->assertTrue($ifMatchEtags->isEmpty());
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function failsWhenInvalidEtagValues(): void
    {
        $this->expectException(BadRequestHttpException::class);

        $request = $this->createRequest(
            ifMatch: 'W/"8741", invalid-etag-value"',
        );

        $request->etagsFrom('If-Match');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canGetIfMatchEtags(): void
    {
        $request = $this->createRequest(
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
    #[Test]
    public function canGetIfNoneMatchEtags(): void
    {
        $request = $this->createRequest(
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

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canDetermineWhenIfRangeHeadersHaveValues(): void
    {
        $requestA = $this->createRequest(
            ifRange: '"ab4jf73"'
        );
        $requestB = $this->createRequest(
            ifRange: '"ab4jf73"',
            range: 'bytes=0-150'
        );

        $this->assertFalse($requestA->hasIfRangeHeaders(), '(a) should not be true when "Range" header missing value');
        $this->assertTrue($requestB->hasIfRangeHeaders(), '(b) should be true when "If-Range" and "Range" headers set');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainEtagOrDateFromIfRangeHeader(): void
    {
        $requestA = $this->createRequest(
            ifRange: '"ab4jf73"'
        );

        $result = $requestA->ifRangeEtagOrDate();
        $this->assertNull($result, 'Should not return anything when only "If-Range" header set');

        // ---------------------------------------------------------------------- //

        $requestB = $this->createRequest(
            ifRange: '"ab4jf73"',
            range: 'bytes=0-150'
        );

        $result = $requestB->ifRangeEtagOrDate();
        $this->assertInstanceOf(ETag::class, $result, 'Value should be an ETag');
        $this->assertSame('ab4jf73', $result->raw());

        // ---------------------------------------------------------------------- //

        $date = today();
        $requestB = $this->createRequest(
            ifRange: $date->format(DateTimeInterface::RFC7231),
            range: 'bytes=0-150'
        );

        $result = $requestB->ifRangeEtagOrDate();
        $this->assertInstanceOf(DateTimeInterface::class, $result, 'Value should be a Datetime');
        $this->assertTrue($date->equalTo($result), 'Invalid date');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function failsWhenInvalidDateInIfRangeHeader(): void
    {
        $this->expectException(BadRequestHttpException::class);

        $request = $this->createRequest(
            ifRange: 'my-invalid-date',
            range: 'bytes=0-150'
        );

        $request->ifRangeEtagOrDate();
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function failsWhenInvalidHttpDateGiven(): void
    {
        $this->expectException(BadRequestHttpException::class);

        $request = $this->createRequest(
            ifModifiedSince: 'my-invalid-date',
        );

        $request->httpDateFrom('If-Modified-Since');
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsNullIfModifiedSinceDateWhenIncorrectHttpMethod(): void
    {
        $request = $this->createRequest(
            ifModifiedSince: now()->toRfc7231String(),
            method: 'POST'
        );

        $date = $request->ifModifiedSinceDate();

        ConsoleDebugger::output($date);

        $this->assertNull($date);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsNullIfModifiedSinceDateWhenIfNotMatchedHeaderSet(): void
    {
        $request = $this->createRequest(
            ifNoneMatch: 'W/"1234", W/"aibb4hr", W/"9876"',
            ifModifiedSince: now()->toRfc7231String(),
            method: 'GET'
        );

        $date = $request->ifModifiedSinceDate();

        ConsoleDebugger::output($date);

        $this->assertNull($date);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainIfModifiedSinceDate(): void
    {
        $request = $this->createRequest(
            ifModifiedSince: now()->toRfc7231String(),
            method: 'HEAD'
        );

        $date = $request->ifModifiedSinceDate();

        ConsoleDebugger::output($date);

        $this->assertInstanceOf(DateTimeInterface::class, $date);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsNullIfUnmodifiedSinceDateWhenIfMatchHeaderSet(): void
    {
        $request = $this->createRequest(
            ifMatch: 'W/"1234"',
            ifUnmodifiedSince: now()->toRfc7231String(),
        );

        $date = $request->ifUnmodifiedSinceDate();

        ConsoleDebugger::output($date);

        $this->assertNull($date);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainIfUnmodifiedSinceDate(): void
    {
        $request = $this->createRequest(
            ifUnmodifiedSince: now()->toRfc7231String(),
        );

        $date = $request->ifUnmodifiedSinceDate();

        ConsoleDebugger::output($date);

        $this->assertInstanceOf(DateTimeInterface::class, $date);
    }
}
