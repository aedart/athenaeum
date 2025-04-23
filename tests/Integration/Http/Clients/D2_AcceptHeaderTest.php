<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;

/**
 * D2_AcceptHeaderTest
 *
 * @group http-clients
 * @group http-clients-d2
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-d2',
)]
class D2_AcceptHeaderTest extends HttpClientsTestCase
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
    public function usesAcceptHeaderForRequest(string $profile)
    {
        $client = $this->client($profile);

        $contentType = 'text/html; charset=UTF-8';

        /** @var ResponseInterface $response */
        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withAccept($contentType)
            ->request('get', '/users');

        $headerFromSent = $this->lastRequest->getHeader('Accept')[0];
        $this->assertSame($contentType, $headerFromSent, 'Incorrect Accept Content-Type header on request');
    }
}
