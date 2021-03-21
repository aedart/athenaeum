<?php

namespace Aedart\Tests\Unit\Acl\Traits;

use Aedart\Acl\Traits\RegistrarTrait;
use Aedart\Tests\TestCases\TraitTestCase;

/**
 * AclTraitsTest
 *
 * @group acl
 * @group acl-traits
 * @group traits
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Acl\Traits
 */
class AclTraitsTest extends TraitTestCase
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
            'RegistrarTrait' => [ RegistrarTrait::class ],
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