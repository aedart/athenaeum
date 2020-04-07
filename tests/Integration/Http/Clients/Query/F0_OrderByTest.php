<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * F0_OrderByTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-f0
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class F0_OrderByTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data order by single field asc test
     *
     * @return array
     */
    public function providesOrderBySingleFieldAsc()
    {
        return [
            'default' => [
                'default',
                'sort=name asc'
            ],
            'json api' => [
                'json_api',
                'sort=name'
            ],
            'odata' => [
                'odata',
                '$orderby=name asc'
            ],
        ];
    }

    /**
     * Provides data order by single field desc test
     *
     * @return array
     */
    public function providesOrderBySingleFieldDesc()
    {
        return [
            'default' => [
                'default',
                'sort=name desc'
            ],
            'json api' => [
                'json_api',
                'sort=-name'
            ],
            'odata' => [
                'odata',
                '$orderby=name desc'
            ],
        ];
    }

    /**
     * Provides data order by multiple fields test
     *
     * @return array
     */
    public function providesOrderByMultipleFields()
    {
        return [
            'default' => [
                'default',
                'sort=name asc,age desc'
            ],
            'json api' => [
                'json_api',
                'sort=name,-age'
            ],
            'odata' => [
                'odata',
                '$orderby=name asc,age desc'
            ],
        ];
    }

    /**
     * Provides data order by multiple fields via array test
     *
     * @return array
     */
    public function providesOrderByMultipleFieldsViaArray()
    {
        return [
            'default' => [
                'default',
                'sort=name desc,age asc,jobs asc'
            ],
            'json api' => [
                'json_api',
                'sort=-name,age,jobs'
            ],
            'odata' => [
                'odata',
                '$orderby=name desc,age asc,jobs asc'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesOrderBySingleFieldAsc
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     */
    public function canOrderBySingleFieldAsc(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->orderBy('name')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesOrderBySingleFieldDesc
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     */
    public function canOrderBySingleFieldDesc(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->orderBy('name', 'desc')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesOrderByMultipleFields
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     */
    public function canOrderByMultipleFields(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->orderBy('name')
            ->orderBy('age', 'desc')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesOrderByMultipleFieldsViaArray
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException
     */
    public function canOrderByMultipleFieldsViaArray(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->orderBy([
                'name' => 'desc',
                'age',
                'jobs' => 'asc'
            ])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
