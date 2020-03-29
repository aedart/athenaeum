<?php

namespace Aedart\Tests\Integration\Http\Clients\Managers;

use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * HttpQueryGrammarManagerTest
 *
 * @group http
 * @group http-clients
 * @group http-query-manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients\Managers
 */
class HttpQueryGrammarManagerTest extends HttpClientsTestCase
{
    /**
     * @test
     */
    public function canObtainInstance()
    {
        $manager = $this->getGrammarManager();

        $this->assertNotNull($manager);
    }

    /**
     * @test
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    public function canCreateDefaultGrammar()
    {
        $manager = $this->getGrammarManager();
        $grammar = $manager->profile();

        $this->assertInstanceOf(Grammar::class, $grammar);
    }

    /**
     * @test
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    public function returnsSameGrammar()
    {
        $manager = $this->getGrammarManager();

        $grammarA = $manager->profile();
        $grammarB = $manager->profile();

        $this->assertSame($grammarA, $grammarB);
    }
}
