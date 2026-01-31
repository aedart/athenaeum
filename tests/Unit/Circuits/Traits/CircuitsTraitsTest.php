<?php

namespace Aedart\Tests\Unit\Circuits\Traits;

use Aedart\Circuits\Traits\CircuitBreakerManagerTrait;
use Aedart\Circuits\Traits\CircuitBreakerTrait;
use Aedart\Circuits\Traits\FailureFactoryTrait;
use Aedart\Circuits\Traits\StateFactoryTrait;
use Aedart\Circuits\Traits\StoreTrait;
use Aedart\Tests\TestCases\TraitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * CircuitsTraitsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Circuits\Traits
 */
#[Group(
    'circuits',
    'circuits-traits',
    'traits'
)]
class CircuitsTraitsTest extends TraitTestCase
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
            'CircuitBreakerTrait' => [ CircuitBreakerTrait::class ],
            'CircuitBreakerManagerTrait' => [ CircuitBreakerManagerTrait::class ],
            'StoreTrait' => [ StoreTrait::class ],
            'StateFactoryTrait' => [ StateFactoryTrait::class ],
            'FailureFactoryTrait' => [ FailureFactoryTrait::class ],
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
