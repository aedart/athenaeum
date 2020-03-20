<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
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
        $this->assertSame([
            $key => [ $type => $value ]
        ], $builder->getQuery());
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canApplyMultipleWhereClausesForSameField(string $profile)
    {
        $client = $this->client($profile);

        $builder = $client
            ->where('year', 'gt', '2021')
            ->where('year', 'lt', '2088');

        // --------------------------------------------------- //

        $query = $builder->getQuery();

        ConsoleDebugger::output($query);

        $this->assertSame([
            'year' => [
                'gt' => '2021',
                'lt' => '2088',
            ]
        ], $builder->getQuery());
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function acceptsListOfFieldsWithValues(string $profile)
    {
        $client = $this->client($profile);

        $fields = [
            'name' => 'Cris',
            'has_pets' => true,
            'items' => ['x', 'y', 'z'],
            'date' => [
                'gt' => '1985',
                'lt' => '2034'
            ]
        ];

        $builder = $client->where($fields);

        // --------------------------------------------------- //

        $query = $builder->getQuery();

        ConsoleDebugger::output($query);

        $this->assertSame($fields, $builder->getQuery());
    }
}
