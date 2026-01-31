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
 * C10_WhereDayTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-g4',
    'http-query-grammars',
)]
class G4_WhereDayTest extends HttpClientsTestCase
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
     * Provides data for or where day test
     *
     * @return array
     */
    public function providesOrWhereDay()
    {
        $expectedA = now()->format('d');
        $expectedB = now()->addDays(2)->format('d');

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
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesWhereDay')]
    #[Test]
    public function canAddWhereDay(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereDay('created', now())
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesOrWhereDay')]
    #[Test]
    public function canAddOrWhereDay(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereDay('created', now())
            ->orWhereDay('created', now()->addDays(2))
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
