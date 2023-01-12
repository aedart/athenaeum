<?php

namespace Aedart\Tests\Integration\ETags\Preconditions\Rfc9110;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Facades\Generator;
use Aedart\ETags\Preconditions\Actions\DefaultActions;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Throwable;

/**
 * IfUnmodifiedSinceTest
 *
 * @group etags
 * @group preconditions
 * @group rfc9110-if-unmodified-since
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions\Rfc9110
 */
class IfUnmodifiedSinceTest extends PreconditionsTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    public function continuesToIfNoneMatchWhenPasses(): void
    {
        // NOTE: [...] If the selected representation's last modification date is EARLIER than or EQUAL to
        // the date provided in the field value, the condition is TRUE. [...]

        $lastModified = now()->subMinutes(3)->toRfc7231String();
        $resource = $this->makeResourceContext(
            lastModifiedDate: Carbon::make($lastModified)
        );

        $request = $this->createRequest(
            ifUnmodifiedSince: $lastModified
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 2. When recipient is the origin server, If-Match is not present, and If-Unmodified-Since is present, [...]:
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
    public function passesWhenLastModifiedEarlierThanUnmodified(): void
    {
        // NOTE: [...] If the selected representation's last modification date is EARLIER than or EQUAL to
        // the date provided in the field value, the condition is TRUE. [...]

        $lastModified = now()->subMinutes(7)->toRfc7231String();
        $resource = $this->makeResourceContext(
            lastModifiedDate: Carbon::make($lastModified)
        );

        $request = $this->createRequest(
            ifUnmodifiedSince: now()->subMinutes(3)->toRfc7231String()
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 2. When recipient is the origin server, If-Match is not present, and If-Unmodified-Since is present, [...]:
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
    public function respondsPreconditionFailsWhenConditionFails(): void
    {
        $this->expectException(PreconditionFailedHttpException::class);

        // -------------------------------------------------------------------- //

        // NOTE: [...] If the selected representation's last modification date is EARLIER than or EQUAL to
        // the date provided in the field value, the condition is TRUE. [...]

        $lastModified = now()->subMinutes(3)->toRfc7231String();
        $resource = $this->makeResourceContext(
            lastModifiedDate: Carbon::make($lastModified)
        );

        $request = $this->createRequest(
            ifUnmodifiedSince: now()->subMinutes(7)->toRfc7231String()
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 2. When recipient is the origin server, If-Match is not present, and If-Unmodified-Since is present, [...]:
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
    public function abortsIfStateChangeAlreadySucceeded(): void
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('State already changed');

        // -------------------------------------------------------------------- //

        $lastModified = now()->subMinutes(7)->toRfc7231String();
        $resource = $this->makeResourceContext(
            lastModifiedDate: Carbon::make($lastModified),
            determineStateChangeSuccess: function() {
                return true;
            }
        );

        $request = $this->createRequest(
            ifUnmodifiedSince: now()->subMinutes(10)->toRfc7231String()
        );

        $evaluator = $this->makeEvaluator(
            request: $request,
            actions: new class extends DefaultActions
            {
                public function abortStateChangeAlreadySucceeded(ResourceContext $resource)
                {
                    throw new HttpException(200, 'State already changed');
                }
            }
        );

        // -------------------------------------------------------------------- //

        // 2. When recipient is the origin server, If-Match is not present, and If-Unmodified-Since is present, [...]:
        // [...] if false, respond 412 (Precondition Failed) unless it can be determined that the state-changing
        // request has already succeeded [...] if the request is a state-changing operation that appears to have
        // already been applied to the selected representation, the origin server MAY respond with a 2xx
        // (Successful) status code [...]
        $evaluator->evaluate($resource);
    }
}