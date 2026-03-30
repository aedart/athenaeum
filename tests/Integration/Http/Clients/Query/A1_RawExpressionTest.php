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
 * A1_RawExpressionTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-a1',
    'http-query-grammars',
)]
class A1_RawExpressionTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides raw expression test data
     *
     * @return array
     */
    public function providesWhereRawData(): array
    {
        $expected = 'search=person from (a,b,c)';

        // NOTE: We do NOT care about if the syntax is correct or not for each
        // grammar. We only care that the expression is added exactly as stated.
        return [
            'default' => [ 'default', $expected ],
            'json api' => [ 'json_api', $expected ],
            'odata' => [ 'odata', $expected ],
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
    #[DataProvider('providesWhereRawData')]
    #[Test]
    public function canAddRawExpressions(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->raw('search=person from (:list)', [ 'list' => 'a,b,c' ])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
