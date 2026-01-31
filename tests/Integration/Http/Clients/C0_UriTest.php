<?php


namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Teapot\StatusCode;

/**
 * C0_UriTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-c0',
)]
class C0_UriTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canSetRequestUri(string $profile)
    {
        $client = $this->client($profile);

        $uri = '/' . $this->getFaker()->word();

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
        $this->assertSame(StatusCode::OK, $response->getStatusCode());
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function extractsQueryFromUri(string $profile)
    {
        $client = $this->client($profile);

        $uri = '/' . $this->getFaker()->word() . '?foo=bar';

        $builder = $client->from($uri);

        // ------------------------------------------------------- //

        $query = $builder->query();
        $raw = $query->toArray()[Builder::RAW];

        $this->assertNotEmpty($raw, 'No raw expression available');
        $this->assertSame([ Builder::EXPRESSION => 'foo=bar', Builder::BINDINGS => [] ], array_pop($raw), 'Incorrect query extraction');
        $this->assertEmpty($builder->getUri()->getQuery(), 'Uri instance still has a http query');
    }
}
