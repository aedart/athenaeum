<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Core\Bootstrappers\DetectAndLoadEnvironment;
use Aedart\Core\Bootstrappers\LoadConfiguration;
use Aedart\Core\Bootstrappers\RegisterApplicationAliases;
use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * E1_AliasRegistrationTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
#[Group(
    'application',
    'application-e2',
)]
class E2_AliasRegistrationTest extends AthenaeumCoreTestCase
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
            RegisterApplicationAliases::class
        ]);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    #[Test]
    public function hasRegisteredAliases()
    {
        $this->bootstrap();

        $key = 'lipsum';
        $this->assertTrue($this->app->bound($key), 'Alias not registered');

        $expected = $this->app->make('files');
        $instance = $this->app->make($key);
        $this->assertSame($expected, $instance, 'Incorrect alias binding');
    }
}
