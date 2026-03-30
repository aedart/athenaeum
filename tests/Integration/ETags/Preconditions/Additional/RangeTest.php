<?php

namespace Aedart\Tests\Integration\ETags\Preconditions\Additional;

use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * RangeTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions\Additional
 */
#[Group(
    'etags',
    'preconditions',
    'additional-preconditions-range'
)]
class RangeTest extends PreconditionsTestCase
{
    /**
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function mustProcessRangeWhenRequested(): void
    {
        // x. When "Range" is requested, but without "If-Range" header, and "Range" is supported.
        // Strictly speaking, this is NOT part of RFC9110's "13.2. Evaluation of Preconditions".
        // However, "Range" header must be processed when received, even without "If-Range".

        $resource = $this->makeResourceContext(
            size: 512
        );

        $request = $this->createRequest(
            range: 'bytes=0-299',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // x. When "Range" is requested, but without "If-Range" header, and "Range" is supported.
        // Strictly speaking, this is NOT part of RFC9110's "13.2. Evaluation of Preconditions".
        // However, "Range" header must be processed when received, even without "If-Range".
        $result = $evaluator->evaluate($resource);

        // Evaluator does not produce response, but the resource context is flagged to
        // process range field...
        $this->assertSame($resource, $result);
        $this->assertTrue($resource->mustProcessRange(), 'Range field should be processed');
        $this->assertNotNull($resource->ranges(), 'No ranges available in context');
    }

    /**
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function mustNotProcessRangeWhenResourceIsEmpty(): void
    {
        // x. When "Range" is requested, but without "If-Range" header, and "Range" is supported.
        // Strictly speaking, this is NOT part of RFC9110's "13.2. Evaluation of Preconditions".
        // However, "Range" header must be processed when received, even without "If-Range".

        $resource = $this->makeResourceContext(
            size: 0
        );

        $request = $this->createRequest(
            range: 'bytes=100-200',
            method: 'get'
        );

        $evaluator = $this->makeEvaluator($request);

        // -------------------------------------------------------------------- //

        // x. When "Range" is requested, but without "If-Range" header, and "Range" is supported.
        // Strictly speaking, this is NOT part of RFC9110's "13.2. Evaluation of Preconditions".
        // However, "Range" header must be processed when received, even without "If-Range".
        $result = $evaluator->evaluate($resource);

        // Evaluator does not produce response, but the resource context is flagged to
        // process range field...
        $this->assertSame($resource, $result);
        $this->assertTrue($resource->mustIgnoreRange());
        $this->assertNull($resource->ranges(), 'Ranges should be empty');
    }
}
