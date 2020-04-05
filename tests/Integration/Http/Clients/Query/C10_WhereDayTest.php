<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C10_WhereDayTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-c10
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class C10_WhereDayTest extends HttpClientsTestCase
{

    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where day test
     *
     * @return array
     */
    public function providesWhereDay()
    {
        $expected = now()->format('d');

        return [
            'default' => [
                'default',
                '?created=' . $expected
            ],
            'json api' => [
                'json_api',
                '?filter[created]=' . $expected
            ],
            'odata' => [
                'odata',
                '?$filter=created eq ' . $expected
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesWhereDay
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    public function canAddWhereDay(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereDay('created', now())
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
