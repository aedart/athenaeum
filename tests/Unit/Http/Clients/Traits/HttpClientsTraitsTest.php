<?php

namespace Aedart\Tests\Unit\Http\Clients\Traits;

use Aedart\Http\Clients\Requests\Builders\Guzzle\Traits\CookieJarTrait as GuzzleCookieJarTrait;
use Aedart\Http\Clients\Traits\GrammarManagerTrait;
use Aedart\Http\Clients\Traits\GrammarTrait;
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use Aedart\Http\Clients\Traits\HttpRequestBuilderTrait;
use Aedart\Tests\TestCases\TraitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * Http Clients Traits Test
 *
 * @group http
 * @group http-clients
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Clients\Traits
 */
#[Group(
    'http',
    'http-clients',
    'traits'
)]
class HttpClientsTraitsTest extends TraitTestCase
{
    /*****************************************************************
     * Providers
     ****************************************************************/

    /**
     * @return array
     */
    public function awareOfComponentsProvider()
    {
        return [
            'HttpClientsManagerTrait' => [ HttpClientsManagerTrait::class ],
            'HttpClientTrait' => [ HttpClientTrait::class ],
            'HttpRequestBuilderTrait' => [ HttpRequestBuilderTrait::class ],
            'CookieJarTrait (Guzzle)' => [GuzzleCookieJarTrait::class],
            'GrammarManagerTrait' => [GrammarManagerTrait::class],
            'GrammarTrait' => [GrammarTrait::class]
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider awareOfComponentsProvider
     *
     * @param string $awareOfTrait
     *
     * @throws \ReflectionException
     */
    #[DataProvider('awareOfComponentsProvider')]
    #[Test]
    public function canInvokeAwareOfMethods(string $awareOfTrait)
    {
        $this->assertTraitMethods($awareOfTrait, null, null);
    }
}
