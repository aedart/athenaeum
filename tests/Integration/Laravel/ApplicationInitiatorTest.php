<?php

namespace Aedart\Tests\Integration\Laravel;

use Aedart\Testing\Laravel\LaravelTestHelper;
use Codeception\Attribute\Group;
use Codeception\Test\Unit;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use PHPUnit\Framework\Attributes\Test;

/**
 * ApplicationInitiatorTest
 *
 * @group laravel
 * @group testing
 * @group app-initiator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Laravel
 */
#[Group(
    'laravel',
    'testing',
    'app-initiator',
)]
class ApplicationInitiatorTest extends Unit
{
    use LaravelTestHelper;

    /*****************************************************************
     * Setup Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $this->startApplication();
    }

    /**
     * {@inheritdoc}
     */
    protected function _after()
    {
        parent::_after();

        $this->stopApplication();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    #[Test]
    public function applicationHasStarted()
    {
        $this->assertTrue($this->hasApplicationBeenStarted());
    }

    /**
     * @test
     */
    #[Test]
    public function laravelApplicationIsAvailable()
    {
        $app = $this->getApplication();

        $this->assertInstanceOf(Application::class, $app);
    }

    /**
     * @test
     */
    #[Test]
    public function laravelComponentIsAvailable()
    {
        $app = $this->getApplication();

        /** @var Repository $config */
        $config = $app['config'];
        $this->assertInstanceOf(Repository::class, $config);

        // Assert a typical config is available
        $this->assertNotEmpty($config->get('cache.default'));
    }
}
