<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use InvalidArgumentException;

/**
 * C2_WhereTest
 *
 * @group http-clients
 * @group http-clients-c2
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class C2_WhereTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function setsQueryViaWhereMethod(string $profile)
    {
        $client = $this->client($profile);

        $key = 'desc';
        $value = 'Bucaneers die from punishments like swashbuckling landlubbers.';

        $builder = $client->where($key, $value);

        // --------------------------------------------------- //

        $this->assertTrue($builder->hasQuery(), 'No query available');
        $this->assertSame([ $key => $value ], $builder->getQuery());
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canSetSparseFieldSetQuery(string $profile)
    {
        $client = $this->client($profile);

        $key = 'year';
        $type = 'gt';
        $value = '2020';

        $builder = $client->where($key, $type, $value);

        // --------------------------------------------------- //

        $this->assertTrue($builder->hasQuery(), 'No query available');
        $this->assertSame([ "{$key}[{$type}]" => $value ], $builder->getQuery());
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function failsWhenTypeInvalid(string $profile)
    {
        $this->expectException(InvalidArgumentException::class);

        $client = $this->client($profile);

        $key = 'invalid';
        $type = $client;
        $value = 'argument';

        $client->where($key, $type, $value);
    }
}