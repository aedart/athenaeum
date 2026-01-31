<?php

namespace Aedart\Tests\Integration\ETags\Preconditions\Rfc9110;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Facades\Generator;
use Aedart\ETags\Preconditions\Actions\DefaultActions;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Throwable;

/**
 * IfNoneMatchTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions\Rfc9110
 */
#[Group(
    'etags',
    'preconditions',
    'rfc9110-if-none-match'
)]
class IfNoneMatchTest extends PreconditionsTestCase
{
    /**
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function continuesToIfRangeWhenPasses(): void
    {
        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag
        );

        $request = $this->createRequest(
            ifNoneMatch: Generator::makeWeak('1324')->toString(),
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 3. When If-None-Match is present, [...]:
        // [...] if true, continue to step 5 (If-Range)
        $result = $evaluator->evaluate($resource);

        // This test is unable to verify that next precondition is actually evaluated.
        // However, it should pass and the resource should be the result of this...
        $this->assertSame($resource, $result);
    }

    /**
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function failsWhenWildcardRequested(): void
    {
        // [...] if false for GET/HEAD, respond 304 (Not Modified)
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Not modified');

        // -------------------------------------------------------------------- //

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag
        );

        // [...] If the field value is "*", the condition is FALSE if the origin server has a current representation for the target resource.
        $request = $this->createRequest(
            ifNoneMatch: '*',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator(
            request: $request,
            actions: new class() extends DefaultActions {
                public function abortNotModified(ResourceContext $resource): never
                {
                    throw new HttpException(304, 'Not modified');
                }
            }
        );

        // -------------------------------------------------------------------- //

        $evaluator->evaluate($resource);
    }

    /**
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function failsWhenListOfEtagsWithMatchingValueRequested(): void
    {
        // [...] if false for GET/HEAD, respond 304 (Not Modified)
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Not modified');

        // -------------------------------------------------------------------- //

        $etag = Generator::makeRaw('abc', true);
        $resource = $this->makeResourceContext(
            etag: $etag
        );

        // [...] If the field value is a list of entity tags, the condition is FALSE if one of the listed tags matches the entity tag of the selected representation.
        $request = $this->createRequest(
            ifNoneMatch: 'W/"1234", W/"4321", W/"abc"',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator(
            request: $request,
            actions: new class() extends DefaultActions {
                public function abortNotModified(ResourceContext $resource): never
                {
                    throw new HttpException(304, 'Not modified');
                }
            }
        );

        // -------------------------------------------------------------------- //

        $evaluator->evaluate($resource);
    }

    /**
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function respondsPreconditionFails(): void
    {
        // [...] if false for GET/HEAD, respond 304 (Not Modified)
        // [...] if false for other methods, respond 412 (Precondition Failed)

        $this->expectException(PreconditionFailedHttpException::class);

        // -------------------------------------------------------------------- //

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag
        );

        $request = $this->createRequest(
            ifNoneMatch: '*',
            method: 'patch'
        );

        $evaluator = $this->makeEvaluator(
            request: $request
        );

        // -------------------------------------------------------------------- //

        $evaluator->evaluate($resource);
    }
}
