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
 * C0_WhereTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-c0',
    'http-query-grammars',
)]
class C0_WhereTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where field equals value test
     *
     * @return array
     */
    public function providesWhereFieldEqualsValue(): array
    {
        return [
            'default' => [
                'default',
                'name=john'
            ],
            'json api' => [
                'json_api',
                'filter[name]=john'
            ],
            'odata' => [
                'odata',
                '$filter=name eq \'john\''
            ],
        ];
    }

    /**
     * Provides data for where with operator and value test
     *
     * @return array
     */
    public function providesWhereWithOperatorAndValue(): array
    {
        return [
            'default' => [
                'default',
                'year[gt]=2020'
            ],
            'json api' => [
                'json_api',
                'filter[year][gt]=2020'
            ],
            'odata' => [
                'odata',
                '$filter=year gt 2020'
            ],
        ];
    }

    /**
     * Provides data for multiple conditions on same field test
     *
     * @return array
     */
    public function providesMultipleConditionsOnSameField(): array
    {
        return [
            'default' => [
                'default',
                'year[gt]=2020&year[lt]=2051'
            ],
            'json api' => [
                'json_api',
                'filter[year][gt]=2020&filter[year][lt]=2051'
            ],
            'odata' => [
                'odata',
                '$filter=year gt 2020 and year lt 2051'
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
                'year[gt]=2021&year[lt]=2031&name=john'
            ],
            'json api' => [
                'json_api',
                'filter[year][gt]=2021&filter[year][lt]=2031&filter[name]=john'
            ],
            'odata' => [
                'odata',
                '$filter=year gt 2021 and year lt 2031 and name eq \'john\''
            ],
        ];
    }

    /**
     * Provides data for where with array values test
     *
     * @return array
     */
    public function providesWhereWithArrayValue(): array
    {
        return [
            'default' => [
                'default',
                'users[0]=1&users[1]=2&users[2]=3&users[3]=4'
            ],
            'json api' => [
                'json_api',
                'filter[users][0]=1&filter[users][1]=2&filter[users][2]=3&filter[users][3]=4'
            ],

            // NOTE: This IS not a correct syntax, but difficult to guess what operator
            // to use, when an field = array is provided!
            'odata' => [
                'odata',
                '$filter=users eq (1,2,3,4)'
            ],
        ];
    }

    /**
     * Provides data for where with operator and array values test
     *
     * @return array
     */
    public function providesWhereWithOperatorAndArrayValue(): array
    {
        return [
            'default' => [
                'default',
                'users[in][0]=1&users[in][1]=2&users[in][2]=3&users[in][3]=4'
            ],
            'json api' => [
                'json_api',
                'filter[users][in][0]=1&filter[users][in][1]=2&filter[users][in][2]=3&filter[users][in][3]=4'
            ],
            'odata' => [
                'odata',
                '$filter=users in (1,2,3,4)'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param string $grammar
     * @param string $expected
     *
     * @throws HttpQueryBuilderException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesWhereFieldEqualsValue')]
    #[Test]
    public function canAddWhereFieldEqualsValue(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('name', 'john')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @param string $grammar
     * @param string $expected
     *
     * @throws HttpQueryBuilderException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesWhereWithOperatorAndValue')]
    #[Test]
    public function canAddWhereWithOperatorAndValue(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('year', 'gt', 2020)
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @param string $grammar
     * @param string $expected
     *
     * @throws HttpQueryBuilderException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesMultipleConditionsOnSameField')]
    #[Test]
    public function canAddMultipleConditionsOnSameField(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('year', 'gt', 2020)
            ->where('year', 'lt', 2051)
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
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
            ->where([
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

    /**
     * @param string $grammar
     * @param string $expected
     *
     * @throws HttpQueryBuilderException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesWhereWithArrayValue')]
    #[Test]
    public function canAddWhereWithArrayValue(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('users', [1, 2, 3, 4])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @param string $grammar
     * @param string $expected
     *
     * @throws HttpQueryBuilderException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesWhereWithOperatorAndArrayValue')]
    #[Test]
    public function canAddWhereWithOperatorAndArrayValue(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('users', 'in', [1, 2, 3, 4])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
