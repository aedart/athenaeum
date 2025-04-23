<?php

namespace Aedart\Tests\Integration\ETags\Preconditions\Rfc9110;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Actions\DefaultActions;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * IfModifiedSinceTest
 *
 * @group etags
 * @group preconditions
 * @group rfc9110-if-modified-since
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions\Rfc9110
 */
#[Group(
    'etags',
    'preconditions',
    'rfc9110-if-modified-since'
)]
class IfModifiedSinceTest extends PreconditionsTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function continuesToIfRangeWhenPasses(): void
    {
        // NOTE: [...] If the selected representation's last modification date is EARLIER or EQUAL to
        // the date provided in the field value, the condition is FALSE. [...]

        $lastModified = now();
        $resource = $this->makeResourceContext(
            lastModifiedDate: $lastModified
        );

        $request = $this->createRequest(
            ifModifiedSince: now()->subMinutes(3)->toRfc7231String(),
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // 4. When the method is GET or HEAD, If-None-Match is not present, and If-Modified-Since is present, [...]:
        // [...] if true, continue to step 5 (If-Range)
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
    public function failsWhenLastModifiedIsEarlierThanIfModifiedSince(): void
    {
        // [...] if false, respond 304 (Not Modified)
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Not modified');

        // -------------------------------------------------------------------- //

        // NOTE: [...] If the selected representation's last modification date is EARLIER or EQUAL to
        // the date provided in the field value, the condition is FALSE. [...]

        $lastModified = now()->subMinutes(2);
        $resource = $this->makeResourceContext(
            lastModifiedDate: $lastModified
        );

        $request = $this->createRequest(
            ifModifiedSince: now()->toRfc7231String(),
            method: 'get'
        );

        $evaluator = $this->makeEvaluator(
            request: $request,
            actions: new class() extends DefaultActions {
                /**
                 * @inheritDoc
                 */
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
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function failsWhenLastModifiedIsEqualThanIfModifiedSince(): void
    {
        // [...] if false, respond 304 (Not Modified)
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Not modified');

        // -------------------------------------------------------------------- //

        // NOTE: [...] If the selected representation's last modification date is EARLIER or EQUAL to
        // the date provided in the field value, the condition is FALSE. [...]

        $lastModified = now()->subMinutes(2);
        $resource = $this->makeResourceContext(
            lastModifiedDate: $lastModified
        );

        $request = $this->createRequest(
            ifModifiedSince: $lastModified->toRfc7231String(),
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
}
