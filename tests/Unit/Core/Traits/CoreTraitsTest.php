<?php

namespace Aedart\Tests\Unit\Core\Traits;

use Aedart\Core\Traits\ApplicationTrait;
use Aedart\Core\Traits\NamespaceDetectorTrait;
use Aedart\Core\Traits\PathsContainerTrait;
use Aedart\Tests\TestCases\TraitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * CoreTraitsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Core\Traits
 */
#[Group(
    'core',
    'application',
    'application-traits',
    'traits'
)]
class CoreTraitsTest extends TraitTestCase
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
            'PathsContainerTrait' => [ PathsContainerTrait::class ],
            'NamespaceDetectorTrait' => [ NamespaceDetectorTrait::class ],
            'ApplicationTrait' => [ ApplicationTrait::class ],
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
