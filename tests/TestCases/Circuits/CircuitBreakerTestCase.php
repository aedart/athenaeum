<?php

namespace Aedart\Tests\TestCases\Circuits;

use Aedart\Circuits\Providers\CircuitBreakerServiceProvider;
use Aedart\Circuits\Traits\CircuitBreakerManagerTrait;
use Aedart\Testing\TestCases\LaravelTestCase;

/**
 * CircuitsTestCase
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Circuits
 */
abstract class CircuitBreakerTestCase extends LaravelTestCase
{
    use CircuitBreakerManagerTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            CircuitBreakerServiceProvider::class
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/


}
