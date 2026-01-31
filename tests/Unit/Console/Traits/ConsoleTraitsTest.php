<?php

namespace Aedart\Tests\Unit\Console\Traits;

use Aedart\Console\Traits\CoreApplicationTrait;
use Aedart\Console\Traits\LastInputTrait;
use Aedart\Console\Traits\LastOutputTrait;
use Aedart\Tests\TestCases\TraitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ConsoleTraitsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Console\Traits
 */
#[Group(
    'config',
    'config-traits',
    'traits'
)]
class ConsoleTraitsTest extends TraitTestCase
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
            'CoreApplicationTrait' => [ CoreApplicationTrait::class ],
            'LastInputTrait' => [ LastInputTrait::class ],
            'LastOutputTrait' => [ LastOutputTrait::class ],
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
