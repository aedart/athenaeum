<?php

namespace Aedart\Tests\Unit\Translation\Traits;

use Aedart\Tests\TestCases\TraitTestCase;
use Aedart\Translation\Traits\TranslationsExporterManagerTrait;

/**
 * TranslationTraitsTest
 *
 * @group translation
 * @group translation-traits
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Translation\Traits
 */
class TranslationTraitsTest extends TraitTestCase
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
            'TranslationsExportManagerTrait' => [ TranslationsExporterManagerTrait::class ],
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
