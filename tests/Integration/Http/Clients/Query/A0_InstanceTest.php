<?php

namespace Aedart\Tests\Integration\Http\Clients\Query;

use Aedart\Contracts\Http\Clients\Requests\Query\Builder;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

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
            'default' => [ 'default' ]
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
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
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
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    public function hasGrammarInstance(string $grammar)
    {
        $query = $this->query($grammar);
        $grammar = $query->getGrammar();

        $this->assertInstanceOf(Grammar::class, $grammar);
    }
}
