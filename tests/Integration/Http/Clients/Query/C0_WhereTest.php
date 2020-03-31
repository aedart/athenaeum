<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C0_WhereTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-c0
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
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
                '?name=john'
            ]
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
                '?year[gt]=2020'
            ]
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
                '?year[gt]=2020&year[lt]=2051'
            ]
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesWhereFieldEqualsValue
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
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
     * @test
     * @dataProvider providesWhereWithOperatorAndValue
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
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
     * @test
     * @dataProvider providesMultipleConditionsOnSameField
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
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
}
