<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use GuzzleHttp\Psr7\Query;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;

/**
 * C1_QueryTest
 *
 * @group http-clients
 * @group http-clients-c1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-c1',
)]
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
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function extractsStringQueryFromOptions(string $profile)
    {
        $query = 'name=Rudy&age[gt]=23&age[lt]=42';

        $client = $this->client($profile, [
            'query' => $query
        ]);

        $this->assertStringContainsString($query, (string) $client->query(), 'Query not extracted from options');
    }

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
    public function extractsArrayQueryFromOptions(string $profile)
    {
        $query = [
            'name' => 'Matt',
            'has_pets' => false,
            'items' => ['a', 'b', 'c'],
            'date' => [
                'gt' => '2020',
                'lt' => '2054'
            ]
        ];

        $client = $this->client($profile, [
            'query' => $query
        ]);

        $expected = 'name=Matt&has_pets=false&items[0]=a&items[1]=b&items[2]=c&date[gt]=2020&date[lt]=2054';
        $this->assertStringContainsString($expected, (string) $client->query(), 'Query not extracted from options');
    }

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
    public function canSetQueryStringValues(string $profile)
    {
        $client = $this->client($profile);

        $query = [
            'name' => 'Matt',
            'has_pets' => false,
            'items' => ['a', 'b', 'c'],
            'date' => [
                'gt' => '2020',
                'lt' => '2054'
            ]
        ];

        /** @var ResponseInterface $response */
        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->where($query)
            ->request('get', '/users');

        // --------------------------------------------------- //

        $sentQuery = $this->lastRequest->getUri()->getQuery();
        $sentQuery = Query::parse($sentQuery);

        ConsoleDebugger::output($sentQuery);

        $this->assertSame([
            'name' => 'Matt',
            'has_pets' => 'false',
            'items[0]' => 'a',
            'items[1]' => 'b',
            'items[2]' => 'c',
            'date[gt]' => '2020',
            'date[lt]' => '2054',
        ], $sentQuery, 'Incorrect query string values sent');
    }

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
    public function canBuildHttpQueryViaFluentMethods(string $profile)
    {
        $client = $this->client($profile);

        /** @var ResponseInterface $response */
        $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->select('name', 'person')
            ->where('age', 'gt', 32)
            ->include('friends')
            ->orderBy('age', 'desc')
            ->take(5)
            ->skip(3)
            ->request('get', '/users');

        // --------------------------------------------------- //

        $sentQuery = urldecode($this->lastRequest->getUri()->getQuery());

        ConsoleDebugger::output($sentQuery);

        $expected = 'select=person.name&age[gt]=32&include=friends&limit=5&offset=3&sort=age desc';
        $this->assertStringContainsString($expected, $sentQuery, 'Incorrect query built');
    }
}
