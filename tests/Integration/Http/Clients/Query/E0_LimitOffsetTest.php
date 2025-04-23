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
#[Group(
    'http-clients',
    'http-query',
    'http-query-e0',
    'http-query-grammars',
)]
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
                'limit=10'
            ],
            'json api' => [
                'json_api',
                'page[limit]=10'
            ],
            'odata' => [
                'odata',
                '$top=10'
            ],
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
                'offset=5'
            ],
            'json api' => [
                'json_api',
                'page[offset]=5'
            ],
            'odata' => [
                'odata',
                '$skip=5'
            ],
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
                'limit=50&offset=2'
            ],
            'json api' => [
                'json_api',
                'page[limit]=50&page[offset]=2'
            ],
            'odata' => [
                'odata',
                '$top=50&$skip=2'
            ],
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
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesLimit')]
    #[Test]
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
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesOffset')]
    #[Test]
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
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesLimitAndOffset')]
    #[Test]
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
