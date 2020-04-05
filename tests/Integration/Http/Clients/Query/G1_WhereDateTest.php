<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C7_WhereDateTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-g1
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class G1_WhereDateTest extends HttpClientsTestCase
{

    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where date test
     *
     * @return array
     */
    public function providesWhereDate()
    {
        $expected = now()->format('Y-m-d');

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
     * @dataProvider providesWhereDate
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    public function canAddWhereDate(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereDate('created', now())
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
