<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * A0_InstanceTest
 *
 * @group http-clients
 * @group http-query
 * @group http-query-a0
 * @group http-query-grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Query
 */
#[Group(
    'http-clients',
    'http-query',
    'http-query-a0',
    'http-query-grammars',
)]
class A0_InstanceTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides profile names for Http Query Grammars
     *
     * @return array
     */
    public function providesGrammars(): array
    {
        return [
            'default' => [ 'default' ],
            'json api' => [ 'json_api' ],
            'odata' => [ 'odata' ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesGrammars
     *
     * @param string $grammar
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesGrammars')]
    #[Test]
    public function canObtainInstance(string $grammar)
    {
        $query = $this->query($grammar);

        $this->assertInstanceOf(Builder::class, $query);
    }

    /**
     * @test
     * @dataProvider providesGrammars
     *
     * @param string $grammar
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesGrammars')]
    #[Test]
    public function hasGrammarInstance(string $grammar)
    {
        $query = $this->query($grammar);
        $grammar = $query->getGrammar();

        $this->assertInstanceOf(Grammar::class, $grammar);
    }
}
