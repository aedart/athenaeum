<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * E0_LimitOffsetTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-e0
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class E0_LimitOffsetTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for limit test
     *
     * @return array
     */
    public function providesLimit()
    {
        return [
            'default' => [
                'default',
                '?limit=10'
            ],
            'json api' => [
                'json_api',
                '?page[limit]=10'
            ]
        ];
    }

    /**
     * Provides data for offset test
     *
     * @return array
     */
    public function providesOffset()
    {
        return [
            'default' => [
                'default',
                '?offset=5'
            ],
            'json api' => [
                'json_api',
                '?page[offset]=5'
            ]
        ];
    }

    /**
     * Provides data for limit & offset test
     *
     * @return array
     */
    public function providesLimitAndOffset()
    {
        return [
            'default' => [
                'default',
                '?limit=50&offset=2'
            ],
            'json api' => [
                'json_api',
                '?page[limit]=50&page[offset]=2'
            ]
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesLimit
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     */
    public function canSetLimit(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->take(10)
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesOffset
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     */
    public function canSetOffset(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->skip(5)
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesLimitAndOffset
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     */
    public function canSetLimitAndOffset(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->take(50)
            ->skip(2)
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
