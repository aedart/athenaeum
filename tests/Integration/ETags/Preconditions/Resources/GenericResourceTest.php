<?php

namespace Aedart\Tests\Integration\ETags\Preconditions\Resources;

use Aedart\ETags\Facades\Generator;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * GenericResourceTest
 *
 * @group etags
 * @group resource-context
 * @group generic-resource-context
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions\Resources
 */
#[Group(
    'etags',
    'resource-context',
    'generic-resource-context'
)]
class GenericResourceTest extends PreconditionsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canUseCallableAsEtag(): void
    {
        $etag = Generator::makeRaw(1234);
        $callback = fn () => $etag;

        $resource = $this->makeResourceContext(
            etag: $callback
        );

        $result = $resource->etag();

        $this->assertSame($etag, $result);
    }
}
