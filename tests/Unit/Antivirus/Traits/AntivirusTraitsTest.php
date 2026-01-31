<?php

namespace Aedart\Tests\Unit\Antivirus\Traits;

use Aedart\Antivirus\Traits\AntivirusManagerTrait;
use Aedart\Tests\TestCases\TraitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * AntivirusTraitsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Antivirus\Traits
 */
#[Group(
    'antivirus',
    'antivirus-traits',
    'traits'
)]
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
