<?php

namespace Aedart\Tests\Unit\Circuits\Traits;

use Aedart\Circuits\Traits\CircuitBreakerManagerTrait;
use Aedart\Circuits\Traits\CircuitBreakerTrait;
use Aedart\Circuits\Traits\StateFactoryTrait;
use Aedart\Circuits\Traits\StoreTrait;
use Aedart\Tests\TestCases\TraitTestCase;

/**
 * CircuitsTraitsTest
 *
 * @group circuits
 * @group circuits-traits
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Circuits\Traits
 */
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
