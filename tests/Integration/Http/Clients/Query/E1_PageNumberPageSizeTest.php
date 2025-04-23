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
 * E1_PageNumberPageSizeTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-e1
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-e1',
    'http-query-grammars',
)]
class E1_PageNumberPageSizeTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides test data for page with size
     *
     * @return array
     */
    public function providesPageWithSize()
    {
        return [
            'default' => [
                'default',
                'page=3&show=25'
            ],
            'json api' => [
                'json_api',
                'page[number]=3&page[size]=25'
            ],

            // Not supported
            'odata' => [
                'odata',
                ''
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesPageWithSize
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesPageWithSize')]
    #[Test]
    public function canSetPageWithSize(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->page(3, 25)
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
