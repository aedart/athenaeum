<?php

namespace Aedart\Tests\Unit\Service\Traits;

use Aedart\Service\Traits\ServiceProviderRegistrarTrait;
use Aedart\Tests\TestCases\TraitTestCase;

/**
 * ServiceTraitsTest
 *
 * @group service
 * @group service-registrar
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Service\Traits
 */
class ServiceTraitsTest extends TraitTestCase
{
    /**
     * @return array
     */
    public function awareOfComponentsProvider()
    {
        return [
            'ServiceProviderRegistrarTrait' => [ ServiceProviderRegistrarTrait::class ],
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
