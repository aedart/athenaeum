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
 * C3_WhereBooleanTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-c4
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-c4',
    'http-query-grammars',
)]
class C4_WhereBooleanTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where boolean test
     *
     * @return array
     */
    public function providesWhereBoolean()
    {
        return [
            'default' => [
                'default',
                'has_children=true&has_posts=false'
            ],
            'json api' => [
                'json_api',
                'filter[has_children]=true&filter[has_posts]=false'
            ],
            'odata' => [
                'odata',
                '$filter=has_children eq true and has_posts eq false'
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesWhereBoolean
     *
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesWhereBoolean')]
    #[Test]
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
