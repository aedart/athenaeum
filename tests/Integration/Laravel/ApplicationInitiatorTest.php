<?php

namespace Aedart\Tests\Integration\Laravel;

use Aedart\Testing\Laravel\ApplicationInitiator;
use Codeception\TestCase\Test;
use Illuminate\Contracts\Foundation\Application;

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
class ApplicationInitiatorTest extends Test
{
    use ApplicationInitiator;

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
        $this->stopApplication();

        parent::_after();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    public function applicationHasStarted()
    {
        $this->assertTrue($this->hasApplicationBeenStarted());
    }

    /**
     * @test
     */
    public function laravelApplicationIsAvailable()
    {
        $app = $this->getApplication();

        $this->assertInstanceOf(Application::class, $app);
    }
}
