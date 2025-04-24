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
 * IfMatchTest
 *
 * @group etags
 * @group preconditions
 * @group rfc9110-if-match
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions\Rfc9110
 */
#[Group(
    'etags',
    'preconditions',
    'rfc9110-if-match'
)]
class IfMatchTest extends PreconditionsTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function continuesToIfNoneMatchWhenPasses(): void
    {
        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag
        );

        $request = $this->createRequest(
            ifMatch: $etag->toString()
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 1. When recipient is the origin server and If-Match is present, [...]:
        // [...] if true, continue to step 3 (If-None-Match)
        $result = $evaluator->evaluate($resource);

        // This test is unable to verify that next precondition is actually evaluated.
        // However, it should pass and the resource should be the result of this...
        $this->assertSame($resource, $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function respondsPreconditionFailsWhenConditionFails(): void
    {
        $this->expectException(PreconditionFailedHttpException::class);

        // -------------------------------------------------------------------- //

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag
        );

        $request = $this->createRequest(
            ifMatch: Generator::makeWeak('abc'),
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 1. When recipient is the origin server and If-Match is present, [...]:
        // [...] if false, respond 412 (Precondition Failed) ...
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
    public function abortsIfStateChangeAlreadySucceeded(): void
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('State already changed');

        // -------------------------------------------------------------------- //

        $etag = Generator::makeStrong('abc');
        $resource = $this->makeResourceContext(
            etag: $etag,
            determineStateChangeSuccess: function () {
                return true;
            }
        );

        $request = $this->createRequest(
            ifMatch: Generator::makeWeak('abc'),
        );

        $evaluator = $this->makeEvaluator(
            request: $request,
            actions: new class() extends DefaultActions {
                public function abortStateChangeAlreadySucceeded(ResourceContext $resource): never
                {
                    throw new HttpException(200, 'State already changed');
                }
            }
        );

        // -------------------------------------------------------------------- //

        // 1. When recipient is the origin server and If-Match is present, [...]:
        // [...] if false, respond 412 (Precondition Failed) unless it can be determined that the state-changing
        // request has already succeeded [...] if the request is a state-changing operation that appears to have
        // already been applied to the selected representation, the origin server MAY respond with a 2xx
        // (Successful) status code [...]
        $evaluator->evaluate($resource);
    }
}
