<?php


namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * C4_WhereCallbackTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-c5
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
class C5_WhereCallbackTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where callback test
     *
     * @return array
     */
    public function providesWhereCallback()
    {
        return [
            'default' => [
                'default',
                'box_size=10&shirt_size=large'
            ],
            'json api' => [
                'json_api',
                'filter[box_size]=10&filter[shirt_size]=large'
            ],
            'odata' => [
                'odata',
                '$filter=box_size eq 10 and shirt_size eq large'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesWhereCallback
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    public function canAddWhereCallback(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->where('box_size', function () {
                return 5 * 2;
            })
            ->where('shirt_size', function () {
                return 'large';
            })
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
