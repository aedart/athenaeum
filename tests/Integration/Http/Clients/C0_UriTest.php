<?php


namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * C0_UriTest
 *
 * @group http-clients
 * @group http-clients-c0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class C0_UriTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canSetRequestUri(string $profile)
    {
        $client = $this->client($profile);

        $uri = '/' . $this->getFaker()->word;

        // --------------------------------------------- //

        $builder = $client->into($uri);

        $uriFromBuilder = $builder->getUri();
        $this->assertInstanceOf(UriInterface::class, $uriFromBuilder);
        $this->assertSame($uri, $uriFromBuilder->getPath(), 'Incorrect path on Uri');

        // --------------------------------------------- //

        /** @var ResponseInterface $response */
        $response = $builder
            ->withOption('handler', $this->makeRespondsOkMock())
            ->request();

        $sentToUri = $this->lastRequest->getUri();
        $this->assertSame($uri, $sentToUri->getPath(), 'Request did not send to correct uri');
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function extractsQueryFromUri(string $profile)
    {
        $client = $this->client($profile);

        $uri = '/' . $this->getFaker()->word . '?foo=bar';

        $builder = $client->from($uri);

        // ------------------------------------------------------- //

        $this->assertTrue($builder->hasQuery(), 'Builder has not extracted query from uri');
        $this->assertSame([ 'foo' => 'bar' ], $builder->getQuery(), 'Incorrect query extraction');
        $this->assertEmpty($builder->getUri()->getQuery(), 'Uri instance still has a http query');
    }
}
