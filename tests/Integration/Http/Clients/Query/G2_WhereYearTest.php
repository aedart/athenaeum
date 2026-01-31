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
 * C8_WhereYearTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-g2',
    'http-query-grammars',
)]
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
     * Provides data for or where year test
     *
     * @return array
     */
    public function providesOrWhereYear()
    {
        $expectedA = now()->format('Y');
        $expectedB = now()->addYears(2)->format('Y');

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
    #[DataProvider('providesWhereYear')]
    #[Test]
    public function canAddWhereYear(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereYear('created', now())
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
    #[DataProvider('providesOrWhereYear')]
    #[Test]
    public function canAddOrWhereYear(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereYear('created', now())
            ->orWhereYear('created', now()->addYears(2))
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
