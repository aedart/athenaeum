<?php

namespace Aedart\Tests\Integration\ETags\Mixins;

use Aedart\Contracts\ETags\Exceptions\ETagException;
use Aedart\ETags\ETag;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Illuminate\Http\Response;

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
class ResponseETagsMixinTest extends ETagsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function hasInstalledMixinInResponse(): void
    {
        $this->assertTrue(Response::hasMacro('withEtag'), 'withEtag not installed');
        $this->assertTrue(Response::hasMacro('withoutEtag'), 'withoutEtag not installed');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagException
     */
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
}