<?php


namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C8_WhereYearTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-g2
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class G2_WhereYearTest extends HttpClientsTestCase
{

    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where year test
     *
     * @return array
     */
    public function providesWhereYear()
    {
        $expected = now()->format('Y');

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
     * @dataProvider providesWhereYear
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    public function canAddWhereYear(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereYear('created', now())
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
