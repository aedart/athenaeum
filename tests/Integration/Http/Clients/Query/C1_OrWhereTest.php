<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * C6_OrWhereTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-c1
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-c1',
    'http-query-grammars',
)]
class C1_OrWhereTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for or-where test
     *
     * @return array
     */
    public function providesOrWhere()
    {
        return [
            'default' => [
                'default',
                'name=john&|gender=male'
            ],
            'json api' => [
                'json_api',
                'filter[name]=john&filter[|gender]=male'
            ],
            'odata' => [
                'odata',
                '$filter=name eq \'john\' or gender eq \'male\''
            ],
        ];
    }

    /**
     * Provides data for multiple conditions via array test
     *
     * @return array
     */
    public function providesMultipleConditionsViaArray(): array
    {
        return [
            'default' => [
                'default',
                'year[gt]=2021&|year[lt]=2031&|name=john'
            ],
            'json api' => [
                'json_api',
                'filter[year][gt]=2021&filter[|year][lt]=2031&filter[|name]=john'
            ],
            'odata' => [
                'odata',
                '$filter=year gt 2021 or year lt 2031 or name eq \'john\''
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesOrWhere
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesOrWhere')]
    #[Test]
    public function canAddOrWhere(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('name', 'john')
            ->orWhere('gender', 'male')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesMultipleConditionsViaArray
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws HttpQueryBuilderException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesMultipleConditionsViaArray')]
    #[Test]
    public function canAddMultipleConditionsViaArray(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->orWhere([
                'year' => [
                    'gt' => 2021,
                    'lt' => 2031
                ],
                'name' => 'john'
            ])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
