<?php

namespace Aedart\Tests\Unit\Http\Clients\Traits;

use Aedart\Http\Clients\Requests\Builders\Guzzle\Traits\CookieJarTrait as GuzzleCookieJarTrait;
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use Aedart\Tests\TestCases\TraitTestCase;

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
            'CookieJarTrait (Guzzle)' => [GuzzleCookieJarTrait::class]
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
    public function canInvokeAwareOfMethods(string $awareOfTrait)
    {
        $this->assertTraitMethods($awareOfTrait, null, null);
    }
}
