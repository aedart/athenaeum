<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C3_WhereBooleanTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-c3
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class C3_WhereBooleanTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where true test
     *
     * @return array
     */
    public function providesWhereTrue()
    {
        return [
            'default' => [
                'default',
                '?has_children=true&has_posts=false'
            ],
            'json api' => [
                'json_api',
                '?filter[has_children]=true&filter[has_posts]=false'
            ],
            'odata' => [
                'odata',
                '?$filter=has_children eq true and has_posts eq false'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesWhereTrue
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    public function canAddWhereBoolean(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('has_children', true)
            ->where('has_posts', false)
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
