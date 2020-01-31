<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Core\Bootstrappers\DetectAndLoadEnvironment;
use Aedart\Core\Bootstrappers\LoadConfiguration;
use Aedart\Core\Bootstrappers\SetDefaultTimezone;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Configuration;

/**
 * D0_DefaultTimezoneTest
 *
 * @group application
 * @group application-d0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class D0_DefaultTimezoneTest extends AthenaeumCoreTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Bootstrap the application
     */
    protected function bootstrap()
    {
        $this->app->bootstrapWith([
            DetectAndLoadEnvironment::class,
            LoadConfiguration::class,
            SetDefaultTimezone::class
        ]);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    public function defaultTimezoneIsSet()
    {
        $this->bootstrap();

        $timezone = $this->app->getConfig()->get('app.timezone');
        $default = date_default_timezone_get();

        $this->assertSame($timezone, $default);
    }
}
