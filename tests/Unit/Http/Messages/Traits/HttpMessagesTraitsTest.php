<?php

namespace Aedart\Tests\Unit\Http\Messages\Traits;

use Aedart\Http\Messages\Traits\HttpMessageTrait;
use Aedart\Http\Messages\Traits\HttpRequestTrait;
use Aedart\Http\Messages\Traits\HttpResponseTrait;
use Aedart\Http\Messages\Traits\HttpSerializerFactoryTrait;
use Aedart\Http\Messages\Traits\HttpServerRequestTrait;
use Aedart\Tests\TestCases\TraitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

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
#[Group(
    'http',
    'http-messages',
    'traits'
)]
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
            'HttpSerializerFactoryTrait' => [ HttpSerializerFactoryTrait::class ],
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
