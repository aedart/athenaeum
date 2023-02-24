<?php

namespace Aedart\Tests\Unit\Antivirus\Traits;

use Aedart\Antivirus\Traits\AntivirusManagerTrait;
use Aedart\Tests\TestCases\TraitTestCase;

/**
 * AntivirusTraitsTest
 *
 * @group antivirus
 * @group antivirus-traits
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Antivirus\Traits
 */
class AntivirusTraitsTest extends TraitTestCase
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
            'AntivirusManagerTrait' => [ AntivirusManagerTrait::class ],
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