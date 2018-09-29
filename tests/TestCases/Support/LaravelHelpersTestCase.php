<?php

namespace Aedart\Tests\TestCases\Support;

use Aedart\Testing\GetterSetterTraitTester;
use Aedart\Testing\Laravel\LaravelTestHelper;
use Aedart\Testing\TestCases\UnitTestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

/**
 * Laravel Helpers Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Support
 */
abstract class LaravelHelpersTestCase extends UnitTestCase
{
    use LaravelTestHelper;
    use GetterSetterTraitTester;

    /*****************************************************************
     * Setup Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        if( ! $this->hasApplicationBeenStarted()){
            $this->startApplication();
        }

        // Before we obtain it - we need to make a small configuration
        // because the test-fixtures in Orchestra doesn't contain it.
        // We are generating it here, more or less just like Laravel
        Config::set('app.key', Str::random(32));
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

}
