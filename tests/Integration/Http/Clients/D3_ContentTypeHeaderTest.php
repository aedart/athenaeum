<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;

/**
 * D3_ContentTypeHeaderTest
 *
 * @group http-clients
 * @group http-clients-d3
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-d3',
)]
class D3_ContentTypeHeaderTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function usesContentTypeHeaderForRequest(string $profile)
    {
        $client = $this->client($profile);

        $contentType = 'text/plain';

        /** @var ResponseInterface $response */
        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withContentType($contentType)
            ->request('get', '/users');

        $headerFromSent = $this->lastRequest->getHeader('Content-Type')[0];
        $this->assertSame($contentType, $headerFromSent, 'Incorrect Content-Type header on request');
    }
}
