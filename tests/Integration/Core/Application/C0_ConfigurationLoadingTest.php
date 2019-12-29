<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Core\Bootstrappers\DetectAndLoadEnvironment;
use Aedart\Core\Bootstrappers\LoadConfiguration;
use Aedart\Tests\TestCases\AthenaeumAppTestCase;
use Codeception\Configuration;

/**
 * C0_ConfigurationLoadingTest
 *
 * @group application
 * @group application-c0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class C0_ConfigurationLoadingTest extends AthenaeumAppTestCase
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
            LoadConfiguration::class
        ]);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    public function canLoadConfiguration()
    {
        $this->bootstrap();

        $config = $this->app->getConfig();

        $this->assertTrue($config->has('app.name'));
        $this->assertSame('Athenaeum', $config->get('app.name'));
    }
}
