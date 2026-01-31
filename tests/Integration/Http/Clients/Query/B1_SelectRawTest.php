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
 * B1_SelectRawTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-b1',
    'http-query-grammars',
)]
class B1_SelectRawTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides select raw test data
     *
     * @return array
     */
    public function providesSelectRawData(): array
    {
        return [
            'default' => [
                'default',
                'select=account(42)'
            ],
            'json api' => [
                'json_api',
                'fields[]=account(42)'
            ],
            'odata' => [
                'odata',
                '$select=account(42)'
            ],
        ];
    }

    /**
     * Provides injects bindings test data
     *
     * @return array
     */
    public function providesInjectsBindingsData(): array
    {
        return [
            'default' => [
                'default',
                'select=account(3214)'
            ],
            'json api' => [
                'json_api',
                'fields[]=account(3214)'
            ],
            'odata' => [
                'odata',
                '$select=account(3214)'
            ],
        ];
    }

    /**
     * Provides injects bindings test data
     *
     * @return array
     */
    public function providesSelectRegularAndRawData(): array
    {
        return [
            'default' => [
                'default',
                'select=person.name,account(7)'
            ],
            'json api' => [
                'json_api',
                'fields[person]=name&fields[]=account(7)'
            ],
            'odata' => [
                'odata',
                '$select=person.name,account(7)'
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
    #[DataProvider('providesSelectRawData')]
    #[Test]
    public function canSelectRawExpression(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->selectRaw('account(42)')
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
    #[DataProvider('providesInjectsBindingsData')]
    #[Test]
    public function injectsBindings(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->selectRaw('account(:number)', [ 'number' => 3214 ])
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
    #[DataProvider('providesSelectRegularAndRawData')]
    #[Test]
    public function canSelectRegularAndRaw(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->select('name', 'person')
            ->selectRaw('account(:number)', [ 'number' => 7 ])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
