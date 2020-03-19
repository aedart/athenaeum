<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Psr\Http\Message\ResponseInterface;

use function GuzzleHttp\Psr7\parse_query;

/**
 * C1_QueryTest
 *
 * @group http-clients
 * @group http-clients-c1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class C1_QueryTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function extractsStringQueryFromOptions(string $profile)
    {
        $query = 'name=Rudy&age[gt]=23&age[lt]=42';

        $client = $this->client($profile, [
            'query' => $query
        ]);

        $this->assertTrue($client->hasQuery(), 'No query set on builder');
        $this->assertSame([
            'name' => 'Rudy',
            'age[gt]' => '23',
            'age[lt]' => '42'
        ], $client->getQuery(), 'Incorrect query values');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function extractsArrayQueryFromOptions(string $profile)
    {
        $query = [
            'name' => 'Matt',
            'has_pets' => false,
            'items' => ['a', 'b', 'c']
        ];

        $client = $this->client($profile, [
            'query' => $query
        ]);

        $this->assertTrue($client->hasQuery(), 'No query set on builder');
        $this->assertSame($query, $client->getQuery(), 'Incorrect query values');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canSetQueryStringValues(string $profile)
    {
        $client = $this->client($profile);

        $query = [
            'name' => 'Matt',
            'has_pets' => false,
            'items' => ['a', 'b', 'c']
        ];

        /** @var ResponseInterface $response */
        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withQuery($query)
            ->request('get', '/users');

        // --------------------------------------------------- //

        $sentQuery = $this->lastRequest->getUri()->getQuery();
        $sentQuery = parse_query($sentQuery);

        $this->assertSame([
            'name' => 'Matt',
            'has_pets' => '0',
            'items[0]' => 'a',
            'items[1]' => 'b',
            'items[2]' => 'c',
        ], $sentQuery, 'Incorrect query string values sent');
    }
}