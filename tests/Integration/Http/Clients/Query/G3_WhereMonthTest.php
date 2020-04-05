<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C9_WhereMonthTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-g3
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class G3_WhereMonthTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where month test
     *
     * @return array
     */
    public function providesWhereMonth()
    {
        $expected = now()->format('m');

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
     * @dataProvider providesWhereMonth
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    public function canAddWhereMonth(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereMonth('created', now())
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
