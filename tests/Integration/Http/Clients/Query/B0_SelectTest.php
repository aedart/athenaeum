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
 * B0_SelectTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-b0',
    'http-query-grammars',
)]
class B0_SelectTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides data for select single field test
     *
     * @return array
     */
    public function providesSingleFieldData()
    {
        return [
            'default' => [
                'default',
                'select=name'
            ],
            'json api' => [
                'json_api',
                'fields[]=name'
            ],
            'odata' => [
                'odata',
                '$select=name'
            ],
        ];
    }

    /**
     * Provides data for select single field from resource test
     *
     * @return array
     */
    public function providesSingleFieldFromResourceData()
    {
        return [
            'default' => [
                'default',
                'select=person.name'
            ],
            'json api' => [
                'json_api',
                'fields[person]=name'
            ],
            'odata' => [
                'odata',
                '$select=person.name'
            ],
        ];
    }

    /**
     * Provides data for select multiple fields test
     *
     * @return array
     */
    public function providesMultipleFieldsData()
    {
        return [
            'default' => [
                'default',
                'select=name,age,jobTitle'
            ],
            'json api' => [
                'json_api',
                'fields[]=name,age,jobTitle'
            ],
            'odata' => [
                'odata',
                '$select=name,age,jobTitle'
            ],
        ];
    }

    /**
     * Provides data for select multiple fields from resources test
     *
     * @return array
     */
    public function providesMultipleFieldsFromResourcesData()
    {
        return [
            'default' => [
                'default',
                'select=person.name,person.age,position.jobTitle'
            ],
            'json api' => [
                'json_api',
                'fields[person]=name,age&fields[position]=jobTitle'
            ],
            'odata' => [
                'odata',
                '$select=person.name,person.age,position.jobTitle'
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
    #[DataProvider('providesSingleFieldData')]
    #[Test]
    public function canSelectSingleField(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->select('name')
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
    #[DataProvider('providesSingleFieldFromResourceData')]
    #[Test]
    public function canSelectSingleFieldFromResource(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->select('name', 'person')
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
    #[DataProvider('providesMultipleFieldsData')]
    #[Test]
    public function canSelectMultipleFields(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->select(['name', 'age', 'jobTitle'])
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
    #[DataProvider('providesMultipleFieldsFromResourcesData')]
    #[Test]
    public function canSelectMultipleFieldsFromResources(string $grammar, string $expected)
    {
        $result = $this
            ->query($grammar)
            ->select([
                'name' => 'person',
                'age' => 'person',
                'jobTitle' => 'position'
            ])
            ->build();

        ConsoleDebugger::output($result);

        $this->assertSame($expected, $result);
    }
}
