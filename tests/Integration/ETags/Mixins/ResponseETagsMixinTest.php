<?php

namespace Aedart\Tests\Integration\ETags\Mixins;

use Aedart\Contracts\ETags\Exceptions\ETagException;
use Aedart\ETags\ETag;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Test;

/**
 * ResponseETagsMixinTest
 *
 * @group etags
 * @group etags-mixins
 * @group response-etags-mixin
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Mixins
 */
#[Group(
    'etags',
    'etags-mixins',
    'response-etags-mixin'
)]
class ResponseETagsMixinTest extends ETagsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function hasInstalledMixinInResponse(): void
    {
        $this->assertTrue(Response::hasMacro('withEtag'), 'withEtag not installed');
        $this->assertTrue(Response::hasMacro('withoutEtag'), 'withoutEtag not installed');
        $this->assertTrue(Response::hasMacro('withCache'), 'withCache not installed');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canSetEtagViaMacro(): void
    {
        $eTag = ETag::make(1234);

        /** @var Response $response */
        $response = (new Response())
            ->withEtag($eTag);

        $result = $response->headers->get('etag');

        $this->assertNotEmpty($result);
        $this->assertSame((string) $eTag, $result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canRemoveEtagViaMacro(): void
    {
        $eTag = ETag::make(1234);

        /** @var Response $response */
        $response = (new Response('', 200, [
            'etag' => (string) $eTag
        ]))
            ->withoutEtag();

        $result = $response->headers->get('etag');

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canSetCacheHeadersViaMacro(): void
    {
        $eTag = ETag::make(1234, true);

        /** @var Response $response */
        $response = (new Response())
            ->withCache(
                etag: $eTag,
                lastModified: now()->addHours(3)->addSeconds(43),
                private: true
            );

        ConsoleDebugger::output((string) $response);

        $headers = $response->headers;

        $this->assertNotEmpty($headers->get('etag'), 'No etag set');
        $this->assertSame('W/"1234"', $headers->get('etag'), 'Incorrect Etag set');

        $this->assertNotEmpty($headers->get('last-modified'), 'Last Modified not set');

        $this->assertNotEmpty($headers->get('cache-control'), 'Cache Control not set');

        // Note: if more cache control headers are set in this test, then this assertion is a bit wrong...
        $this->assertSame('private', $headers->get('cache-control'), 'Incorrect cache-control');
    }
}
