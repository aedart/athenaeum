<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * D0_IncludeTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-d0
 * @group http-query-grammars
 *
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class D0_IncludeTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Provider
     ****************************************************************/

    /**
     * Provides data for including single resource test
     *
     * @return array
     */
    public function providesSingleResourceData()
    {
        return [
            'default' => [
                'default',
                '?include=jobs'
            ],
            'json api' => [
                'json_api',
                '?include=jobs'
            ]
        ];
    }

    /**
     * Provides data for including multiple resources test
     *
     * @return array
     */
    public function providesMultipleResourcesData()
    {
        return [
            'default' => [
                'default',
                '?include=jobs,posts,friends.name'
            ],
            'json api' => [
                'json_api',
                '?include=jobs,posts,friends.name'
            ]
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesSingleResourceData
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     */
    public function canIncludeSingleResource(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->include('jobs')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesMultipleResourcesData
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     */
    public function canIncludeMultipleResources(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->include('jobs')
            ->include(['posts', 'friends.name'])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
