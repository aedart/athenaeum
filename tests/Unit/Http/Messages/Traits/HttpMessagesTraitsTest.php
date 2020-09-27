<?php

namespace Aedart\Tests\Unit\Http\Messages\Traits;

use Aedart\Http\Messages\Traits\HttpMessageTrait;
use Aedart\Http\Messages\Traits\HttpRequestTrait;
use Aedart\Http\Messages\Traits\HttpResponseTrait;
use Aedart\Http\Messages\Traits\HttpServerRequestTrait;
use Aedart\Tests\TestCases\TraitTestCase;

/**
 * HttpMessagesTraitsTest
 *
 * @group http
 * @group http-messages
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Messages\Traits
 */
class HttpMessagesTraitsTest extends TraitTestCase
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
            'HttpMessageTrait' => [ HttpMessageTrait::class ],
            'HttpRequestTrait' => [ HttpRequestTrait::class ],
            'HttpResponseTrait' => [ HttpResponseTrait::class ],
            'HttpServerRequestTrait' => [ HttpServerRequestTrait::class ],
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
