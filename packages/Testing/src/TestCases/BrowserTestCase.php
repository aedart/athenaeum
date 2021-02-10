<?php

namespace Aedart\Testing\TestCases;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\Laravel\DuskTestHelper;

/**
 * Browser Test Case
 *
 * Codeception Laravel Dusk integration test-case.
 *
 * @see \Aedart\Testing\Laravel\DuskTestHelper
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Testing\TestCases
 */
abstract class BrowserTestCase extends IntegrationTestCase
{
    use DuskTestHelper;

    /**
     * WARNING: Whilst testing using this abstraction,
     * you should avoid allowing the Service Container
     * from the `IntegrationTestCase` to register as
     * "application" - it might cause unwanted behaviour!
     *
     * @var bool
     */
    protected bool $registerAsApplication = false;

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

    /**
     * Prepares chrome driver, before each test
     *
     * @beforeClass
     */
    public static function prepare()
    {
        ConsoleDebugger::output('Starting Chrome Driver');

        static::startChromeDriver([
            'port' => 9515,
            // '--verbose'
        ]);
    }

    /**
     * Starts the server
     *
     * @throws \Orchestra\Testbench\Dusk\Exceptions\UnableToStartServer
     */
    public static function _setUpBeforeClass(): void
    {
        // Disable this, if you already are running a local server.
        // Otherwise you might get refused starting the "Dusk Server".
        static::serve(static::serverHost(), static::serverPort());
    }

    /**
     * Stops the server
     */
    public static function _tearDownAfterClass(): void
    {
        static::stopServing();
    }
}
