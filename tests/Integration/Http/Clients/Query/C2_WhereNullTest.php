<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C2_WhereNullTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-c2
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class C2_WhereNullTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where null test
     *
     * @return array
     */
    public function providesWhereNull()
    {
        return [
            'default' => [
                'default',
                '?name=null'
            ],
            'json api' => [
                'json_api',
                '?filter[name]=null'
            ],
            'odata' => [
                'odata',
                '?$filter=name eq null'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesWhereNull
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    public function canAddWhereNull(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('name', null)
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

}
