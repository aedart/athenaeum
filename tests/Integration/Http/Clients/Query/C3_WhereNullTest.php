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
 * C2_WhereNullTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-c3',
    'http-query-grammars',
)]
class C3_WhereNullTest extends HttpClientsTestCase
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
                'name=null'
            ],
            'json api' => [
                'json_api',
                'filter[name]=null'
            ],
            'odata' => [
                'odata',
                '$filter=name eq null'
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
    #[DataProvider('providesWhereNull')]
    #[Test]
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
