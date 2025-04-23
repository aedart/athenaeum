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
#[Group(
    'http-clients',
    'http-query',
    'http-query-g3',
    'http-query-grammars',
)]
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
                'created=' . $expected
            ],
            'json api' => [
                'json_api',
                'filter[created]=' . $expected
            ],
            'odata' => [
                'odata',
                '$filter=created eq ' . $expected
            ],
        ];
    }

    /**
     * Provides data for or where month test
     *
     * @return array
     */
    public function providesOrWhereMonth()
    {
        $expectedA = now()->format('m');
        $expectedB = now()->addMonths(2)->format('m');

        return [
            'default' => [
                'default',
                'created=' . $expectedA . '&|created=' . $expectedB
            ],
            'json api' => [
                'json_api',
                'filter[created]=' . $expectedA . '&filter[|created]=' . $expectedB
            ],
            'odata' => [
                'odata',
                '$filter=created eq ' . $expectedA . ' or created eq ' . $expectedB
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
    #[DataProvider('providesWhereMonth')]
    #[Test]
    public function canAddWhereMonth(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereMonth('created', now())
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesOrWhereMonth
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesOrWhereMonth')]
    #[Test]
    public function canAddOrWhereMonth(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereMonth('created', now())
            ->orWhereMonth('created', now()->addMonths(2))
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
