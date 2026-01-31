<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Date;
use PHPUnit\Framework\Attributes\Test;

/**
 * C6_WhereDateTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-g0',
    'http-query-grammars',
)]
class G0_WhereDatetimeTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for where datetime test
     *
     * @return array
     */
    public function providesWhereDatetime()
    {
        return [
            'default' => [
                'default',
                'created=2020-04-05T00:00:00+0000'
            ],
            'json api' => [
                'json_api',
                'filter[created]=2020-04-05T00:00:00+0000'
            ],
            'odata' => [
                'odata',
                '$filter=created eq 2020-04-05T00:00:00+0000'
            ],
        ];
    }

    /**
     * Provides data for where datetime from date instance test
     *
     * @return array
     */
    public function providesWhereDatetimeFromDateInstance()
    {
        return [
            'default' => [
                'default',
                'created=2020-04-05T12:29:01+0200'
            ],
            'json api' => [
                'json_api',
                'filter[created]=2020-04-05T12:29:01+0200'
            ],
            'odata' => [
                'odata',
                '$filter=created eq 2020-04-05T12:29:01+0200'
            ],
        ];
    }

    /**
     * Provides data for default date test
     *
     * @return array
     */
    public function providesDefaultDate()
    {
        return [
            'default' => [ 'default' ],
            'json api' => [ 'json_api' ],
            'odata' => [ 'odata' ],
        ];
    }

    /**
     * Provides data for or where datetime test
     *
     * @return array
     */
    public function providesOrWhereDatetime()
    {
        return [
            'default' => [
                'default',
                'created=2020-04-05T00:00:00+0000&|created=2020-04-06T00:00:00+0000'
            ],
            'json api' => [
                'json_api',
                'filter[created]=2020-04-05T00:00:00+0000&filter[|created]=2020-04-06T00:00:00+0000'
            ],
            'odata' => [
                'odata',
                '$filter=created eq 2020-04-05T00:00:00+0000 or created eq 2020-04-06T00:00:00+0000'
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
    #[DataProvider('providesWhereDatetime')]
    #[Test]
    public function canAddWhereDatetime(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereDatetime('created', '2020-04-05')
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
    #[DataProvider('providesWhereDatetimeFromDateInstance')]
    #[Test]
    public function canAddWhereDatetimeFromDateInstance(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereDatetime('created', Date::make('2020-04-05 12:29:01+02:00'))
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }

    /**
     * @param string $grammar
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesDefaultDate')]
    #[Test]
    public function defaultsToNowWhenNoDateGiven(string $grammar)
    {
        $result = $this
            ->query($grammar)
            ->whereDatetime('created')
            ->build();

        ConsoleDebugger::output($result);

        // We do not care for the full format, at the moment.
        // we just wish to check that the current date is part
        // of the output.
        $expected = now()->format('Y-m-d');

        $this->assertStringContainsString($expected, $result);
    }

    /**
     * @param string $grammar
     * @param string $expected
     *
     * @throws ProfileNotFoundException
     * @throws HttpQueryBuilderException
     */
    #[DataProvider('providesOrWhereDatetime')]
    #[Test]
    public function canAddOrWhereDatetime(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->whereDatetime('created', '2020-04-05')
            ->orWhereDatetime('created', '2020-04-06')
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
