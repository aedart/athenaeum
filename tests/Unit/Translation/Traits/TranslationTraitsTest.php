<?php

namespace Aedart\Tests\Unit\Translation\Traits;

use Aedart\Tests\TestCases\TraitTestCase;
use Aedart\Translation\Traits\TranslationsExporterManagerTrait;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * TranslationTraitsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Translation\Traits
 */
#[Group(
    'translation',
    'translation-traits',
    'traits'
)]
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
