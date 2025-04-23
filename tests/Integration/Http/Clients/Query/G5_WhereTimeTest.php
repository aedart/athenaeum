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
 * C11_WhereTimeTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-g5
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-g5',
    'http-query-grammars',
)]
class G5_WhereTimeTest extends HttpClientsTestCase
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
                'created=16:58:00'
            ],
            'json api' => [
                'json_api',
                'filter[created]=16:58:00'
            ],
            'odata' => [
                'odata',
                '$filter=created eq 16:58:00'
            ],
        ];
    }

    /**
     * Provides data for or where time test
     *
     * @return array
     */
    public function providesOrWhereTime()
    {
        return [
            'default' => [
                'default',
                'created=16:58:00&|created=18:58:00'
            ],
            'json api' => [
                'json_api',
                'filter[created]=16:58:00&filter[|created]=18:58:00'
            ],
            'odata' => [
                'odata',
                '$filter=created eq 16:58:00 or created eq 18:58:00'
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
    #[DataProvider('providesWhereTime')]
    #[Test]
    public function canAddWhereTime(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereTime('created', '2020-04-05 16:58')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @test
     * @dataProvider providesOrWhereTime
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesOrWhereTime')]
    #[Test]
    public function canAddOrWhereTime(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereTime('created', '2020-04-05 16:58')
            ->orWhereTime('created', '2020-04-07 18:58')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
