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
 * C1_WhereRawTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-c2
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-c2',
    'http-query-grammars',
)]
class C2_WhereRawTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides where raw test data
     *
     * @return array
     */
    public function providesWhereRawData(): array
    {
        $expected = 'user=john';

        return [
            'default' => [
                'default',
                $expected
            ],
            'json api' => [
                'json_api',
                $expected
            ],

            // NOTE: Here too the syntax is wrong, but have to allow it, e.g. in order
            // to allow advanced filters via OData.
            'odata' => [
                'odata',
                '$filter=user=john'
            ],
        ];
    }

    /**
     * Provides or where raw test data
     *
     * @return array
     */
    public function providesOrWhereRawData(): array
    {
        return [
            'default' => [
                'default',
                'user=john&|gender=male'
            ],
            'json api' => [
                'json_api',
                'user=john&gender=male'
            ],

            // NOTE: Here too the syntax is wrong, but have to allow it, e.g. in order
            // to allow advanced filters via OData.
            'odata' => [
                'odata',
                '$filter=user=john or gender=male'
            ],
        ];
    }

    /**
     * Provides injects bindings test data
     *
     * @return array
     */
    public function providesInjectsBindingsData(): array
    {
        $expected = 'filter=user eq 10';

        return [
            'default' => [
                'default',
                $expected
            ],
            'json api' => [
                'json_api',
                $expected
            ],

            // NOTE: This too provides a wrong syntax,... still, it has to be allowed,
            // for building advanced filtering.
            'odata' => [
                'odata',
                '$filter=filter=user eq 10'
            ],
        ];
    }

    /**
     * Provides combines where with raw where test data
     *
     * @return array
     */
    public function providesCombineWhereWithRawWhere(): array
    {
        return [
            'default' => [
                'default',
                'name[like]=john&filter=age gt 25'
            ],
            'json api' => [
                'json_api',
                'filter[name][like]=john&filter=age gt 25'
            ],

            // NOTE: Same as previous, generates invalid Odata query syntax, but still
            // have to allow it, for the benefit of advanced filters.
            'odata' => [
                'odata',
                '$filter=name like \'john\' and filter=age gt 25'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesWhereRawData
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesWhereRawData')]
    #[Test]
    public function canAddWhereRawExpression(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereRaw('user=john')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesOrWhereRawData
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesOrWhereRawData')]
    #[Test]
    public function canAddOrWhereRawExpression(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereRaw('user=john')
            ->orWhereRaw('gender=male')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesInjectsBindingsData
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesInjectsBindingsData')]
    #[Test]
    public function injectsBindings(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereRaw('filter=user eq :amount', [ 'amount' => 10 ])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesCombineWhereWithRawWhere
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesCombineWhereWithRawWhere')]
    #[Test]
    public function canCombineWhereWithRawWhere(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('name', 'like', 'john')
            ->whereRaw('filter=age gt :amount', [ 'amount' => 25 ])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
