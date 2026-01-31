<?php

namespace Aedart\Tests\Integration\ETags\Preconditions\Rfc9110;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Actions\DefaultActions;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Throwable;

/**
 * IfUnmodifiedSinceTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions\Rfc9110
 */
#[Group(
    'etags',
    'preconditions',
    'rfc9110-if-unmodified-since'
)]
class IfUnmodifiedSinceTest extends PreconditionsTestCase
{
    /**
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function continuesToIfNoneMatchWhenPasses(): void
    {
        // NOTE: [...] If the selected representation's last modification date is EARLIER than or EQUAL to
        // the date provided in the field value, the condition is TRUE. [...]

        $lastModified = now()->subMinutes(3);
        $resource = $this->makeResourceContext(
            lastModifiedDate: $lastModified
        );

        $request = $this->createRequest(
            ifUnmodifiedSince: $lastModified->toRfc7231String()
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
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function passesWhenLastModifiedEarlierThanUnmodified(): void
    {
        // NOTE: [...] If the selected representation's last modification date is EARLIER than or EQUAL to
        // the date provided in the field value, the condition is TRUE. [...]

        $lastModified = now()->subMinutes(7);
        $resource = $this->makeResourceContext(
            lastModifiedDate: $lastModified
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
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function respondsPreconditionFailsWhenConditionFails(): void
    {
        $this->expectException(PreconditionFailedHttpException::class);

        // -------------------------------------------------------------------- //

        // NOTE: [...] If the selected representation's last modification date is EARLIER than or EQUAL to
        // the date provided in the field value, the condition is TRUE. [...]

        $lastModified = now()->subMinutes(3);
        $resource = $this->makeResourceContext(
            lastModifiedDate: $lastModified
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

        $lastModified = now()->subMinutes(7);
        $resource = $this->makeResourceContext(
            lastModifiedDate: $lastModified,
            determineStateChangeSuccess: function () {
                return true;
            }
        );

        $request = $this->createRequest(
            ifUnmodifiedSince: now()->subMinutes(10)->toRfc7231String()
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

        // 2. When recipient is the origin server, If-Match is not present, and If-Unmodified-Since is present, [...]:
        // [...] if false, respond 412 (Precondition Failed) unless it can be determined that the state-changing
        // request has already succeeded [...] if the request is a state-changing operation that appears to have
        // already been applied to the selected representation, the origin server MAY respond with a 2xx
        // (Successful) status code [...]
        $evaluator->evaluate($resource);
    }
}
