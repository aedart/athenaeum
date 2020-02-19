<?php

namespace Aedart\Tests\Unit\Config\Traits;

use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Config\Traits\FileParserFactoryTrait;
use Aedart\Tests\TestCases\TraitTestCase;

/**
 * ConfigTraitsTest
 *
 * @group config
 * @group config-traits
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Config\Traits
 */
class ConfigTraitsTest extends TraitTestCase
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
            'FileParserFactoryTrait' => [ FileParserFactoryTrait::class ],
            'ConfigLoaderTrait' => [ ConfigLoaderTrait::class ],
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
