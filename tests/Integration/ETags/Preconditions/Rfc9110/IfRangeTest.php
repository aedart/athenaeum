<?php

namespace Aedart\Tests\Integration\ETags\Preconditions\Rfc9110;

use Aedart\ETags\Facades\Generator;
use Aedart\ETags\Preconditions\Validators\Exceptions\RangeNotSatisfiable;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * IfRangeTest
 *
 * @group etags
 * @group preconditions
 * @group rfc9110-if-range
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions\Rfc9110
 */
#[Group(
    'etags',
    'preconditions',
    'rfc9110-if-range'
)]
class IfRangeTest extends PreconditionsTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function mustProcessRangeWhenIfRangeEtagMatches(): void
    {
        // [...] If the entity-tag validator provided exactly matches the ETag field value for the
        // selected representation using the strong comparison [...], the condition is true.

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag,
            size: 512
        );

        $request = $this->createRequest(
            ifRange: $etag->toString(),
            range: 'bytes=0-299',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 5. When the method is GET and both Range and If-Range are present, [...]:
        // [...] if true and the Range is applicable to the selected representation,
        // respond 206 (Partial Content) [...]
        $result = $evaluator->evaluate($resource);

        // Evaluator does not produce response, but the resource context is flagged to
        // process range field...
        $this->assertSame($resource, $result);
        $this->assertTrue($resource->mustProcessRange(), 'Range field should be processed');
        $this->assertNotNull($resource->ranges(), 'No ranges available in context');
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function mustIgnoreRangeWhenIfRangeEtagDoesNotMatch(): void
    {
        // [...] If the entity-tag validator provided exactly matches the ETag field value for the
        // selected representation using the strong comparison [...], the condition is true.

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag,
            size: 512
        );

        $request = $this->createRequest(
            ifRange: Generator::makeRaw('1234'),
            range: 'bytes=0-299',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 5. When the method is GET and both Range and If-Range are present, [...]:
        $result = $evaluator->evaluate($resource);

        // Evaluator does not produce response, but the resource context is flagged to
        // IGNORE range field...
        $this->assertSame($resource, $result);
        $this->assertTrue($resource->mustIgnoreRange(), 'Range field SHOULD be ignored');
        $this->assertNull($resource->ranges(), 'Ranges are available, but SHOULD NOT be!');
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function mustProcessRangeWhenIfRangeDateMatches(): void
    {
        // [...] If the HTTP-date validator provided exactly matches the Last-Modified field value for
        // the selected representation, the condition is true. [...]

        $lastModified = now()->subMinutes(3);
        $resource = $this->makeResourceContext(
            lastModifiedDate: $lastModified,
            size: 512
        );

        $request = $this->createRequest(
            ifRange: $lastModified->toRfc7231String(),
            range: 'bytes=0-299,300-450',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 5. When the method is GET and both Range and If-Range are present, [...]:
        // [...] if true and the Range is applicable to the selected representation,
        // respond 206 (Partial Content) [...]
        $result = $evaluator->evaluate($resource);

        // Evaluator does not produce response, but the resource context is flagged to
        // process range field...
        $this->assertSame($resource, $result);
        $this->assertTrue($resource->mustProcessRange(), 'Range field should be processed');
        $this->assertNotNull($resource->ranges(), 'No ranges available in context');
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function mustIgnoreRangeWhenIfRangeDateDoesNotMatch(): void
    {
        // [...] If the HTTP-date validator provided exactly matches the Last-Modified field value for
        // the selected representation, the condition is true. [...]

        $lastModified = now()->subMinutes(3);
        $resource = $this->makeResourceContext(
            lastModifiedDate: $lastModified,
            size: 512
        );

        $request = $this->createRequest(
            ifRange: now()->toRfc7231String(),
            range: 'bytes=0-299',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 5. When the method is GET and both Range and If-Range are present, [...]:
        $result = $evaluator->evaluate($resource);

        // Evaluator does not produce response, but the resource context is flagged to
        // IGNORE range field...
        $this->assertSame($resource, $result);
        $this->assertTrue($resource->mustIgnoreRange(), 'Range field SHOULD be ignored');
        $this->assertNull($resource->ranges(), 'Ranges are available, but SHOULD NOT be!');
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function ignoreRangesWhenNoRangeFieldRequest(): void
    {
        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag,
            size: 512
        );

        $request = $this->createRequest(
            ifRange: $etag->toString(),
            // range: 'bytes=0-299',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        $result = $evaluator->evaluate($resource);

        // [...] A server MUST ignore a Range header field received with a request method that is unrecognized
        // or for which range handling is not defined. For this specification, GET is the only method for
        // which range handling is defined. [...]
        $this->assertSame($resource, $result);
        $this->assertTrue($resource->mustIgnoreRange(), 'Range field SHOULD be ignored');
        $this->assertNull($resource->ranges(), 'Ranges are available, but SHOULD NOT be!');
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function respondsBadRequestWhenUnsupportedRangeSpecifiedRequested(): void
    {
        // [...] A server that supports range requests MAY ignore or reject a Range header
        // field that contains an invalid ranges-specifier [...]

        $allowed = 'my_funky_unit';
        $requested = 'megabytes';

        $this->expectException(BadRequestHttpException::class);

        // -------------------------------------------------------------------- //

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag,
            size: 512,
            rangeUnit: $allowed,
        );

        $request = $this->createRequest(
            ifRange: $etag->toString(),
            range: "{$requested}=0-299",
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        $evaluator->evaluate($resource);
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function respondsBadRequestWhenInvalidRangeFormatRequested(): void
    {
        // [...] A server that supports range requests MAY ignore or reject a Range header
        // field that contains an invalid [...] ranges

        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Unable to parse range: 300-abc');

        // -------------------------------------------------------------------- //

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag,
            size: 512,
        );

        $request = $this->createRequest(
            ifRange: $etag->toString(),
            range: 'bytes=0-299,300-abc',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        $evaluator->evaluate($resource);
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function respondsNotSatisfiableWhenTooManyRangesRequested(): void
    {
        // [...] either the range-unit is not supported for that target resource or the ranges-specifier
        // is unsatisfiable with respect to the selected representation, the server SHOULD send a
        // 416 (Range Not Satisfiable) response. [...]

        $requested = '0-100,101-149,150-199';

        $this->expectException(RangeNotSatisfiable::class);
        $this->expectExceptionMessage(sprintf('Too many range sets requested. Unable to satisfy %s', $requested));

        // -------------------------------------------------------------------- //

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag,
            size: 512,
            maxRangeSets: 2
        );

        $request = $this->createRequest(
            ifRange: $etag->toString(),
            range: "bytes={$requested}",
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        $evaluator->evaluate($resource);
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function respondsNotSatisfiableWhenRangesOverlap(): void
    {
        // [...] either the range-unit is not supported for that target resource or the ranges-specifier
        // is unsatisfiable with respect to the selected representation, the server SHOULD send a
        // 416 (Range Not Satisfiable) response. [...]

        $ranges = [
            '0-100',
            '99-101'
        ];
        $requested = implode(',', $ranges);

        $this->expectException(RangeNotSatisfiable::class);
        $this->expectExceptionMessage(sprintf('Range %s overlaps with previous range %s.', $ranges[1], $ranges[0]));

        // -------------------------------------------------------------------- //

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag,
            size: 512
        );

        $request = $this->createRequest(
            ifRange: $etag->toString(),
            range: "bytes={$requested}",
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        $evaluator->evaluate($resource);
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function respondsNotSatisfiableWhenRequestedRangeIsOutOfBounds(): void
    {
        // [...] either the range-unit is not supported for that target resource or the ranges-specifier
        // is unsatisfiable with respect to the selected representation, the server SHOULD send a
        // 416 (Range Not Satisfiable) response. [...]

        $requested = '512-600';

        $this->expectException(RangeNotSatisfiable::class);
        $this->expectExceptionMessage(sprintf('Unable to satisfy range: %s; length is zero', $requested));

        // -------------------------------------------------------------------- //

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag,
            size: 512,
        );

        $request = $this->createRequest(
            ifRange: $etag->toString(),
            range: "bytes={$requested}",
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        $evaluator->evaluate($resource);
    }
}
