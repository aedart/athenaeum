<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * F0_RunTest
 *
 * @group application
 * @group application-f0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
#[Group(
    'application',
    'application-f0',
)]
class F0_RunTest extends AthenaeumCoreTestCase
{
    /**
     * @test
     *
     * @throws \Throwable
     */
    #[Test]
    public function canRunApplication()
    {
        $this->app->run();

        $this->assertTrue($this->app->isRunning());
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    #[Test]
    public function invokesRunCallback()
    {
        $invoked = false;
        $callback = function () use (&$invoked) {
            $invoked = true;
        };

        $this->app->run($callback);

        $this->assertTrue($invoked);
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    #[Test]
    public function doesNotRunIfAlreadyRunning()
    {
        // Run application
        $this->app->run();

        // ----------------------------------------- //
        $invoked = false;
        $callback = function () use (&$invoked) {
            $invoked = true;
        };

        // Run again
        $this->app->run($callback);

        $this->assertFalse($invoked);
    }
}
