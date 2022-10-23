<?php

namespace Aedart\Tests\Unit\Http\Api\Traits;

use Aedart\Http\Api\Traits\ApiResourceRegistrarTrait;
use Aedart\Tests\TestCases\TraitTestCase;

/**
 * ApiTraitsTest
 *
 * @group http
 * @group http-api
 * @group http-api-traits
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Api\Traits
 */
class ApiTraitsTest extends TraitTestCase
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
            'ApiResourceRegistrarTrait' => [ ApiResourceRegistrarTrait::class ],
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
