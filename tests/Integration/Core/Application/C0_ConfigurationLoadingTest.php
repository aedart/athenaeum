<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Core\Bootstrappers\DetectAndLoadEnvironment;
use Aedart\Core\Bootstrappers\LoadConfiguration;
use Aedart\Testing\TestCases\ApplicationIntegrationTestCase;
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
class C0_ConfigurationLoadingTest extends ApplicationIntegrationTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function applicationPaths(): array
    {
        return array_merge(parent::applicationPaths(), [
            'configPath'    => Configuration::dataDir() . 'configs' . DIRECTORY_SEPARATOR . 'application'
        ]);
    }

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
