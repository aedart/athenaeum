<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C11_WhereTimeTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-c11
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class C11_WhereTimeTest extends HttpClientsTestCase
{

    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where time test
     *
     * @return array
     */
    public function providesWhereTime()
    {
        return [
            'default' => [
                'default',
                '?created=16:58:00'
            ],
            'json api' => [
                'json_api',
                '?filter[created]=16:58:00'
            ],
            'odata' => [
                'odata',
                '?$filter=created eq 16:58:00'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesWhereTime
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    public function canAddWhereTime(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereTime('created', '2020-04-05 16:58')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
