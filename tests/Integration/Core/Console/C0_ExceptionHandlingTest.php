<?php

namespace Aedart\Tests\Integration\Core\Console;

use Aedart\Tests\Helpers\Dummies\Console\Commands\Exceptions\CommandFailure;
use Aedart\Tests\TestCases\Console\AthenaeumCoreConsoleTestCase;
use Codeception\Configuration;

/**
 * C0_ExceptionHandlingTest
 *
 * @group application
 * @group application-console
 * @group application-console-c0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Console
 */
class C0_ExceptionHandlingTest extends AthenaeumCoreConsoleTestCase
{
    /**
     * @inheritdoc
     */
    protected function _before()
    {
        // Cleanup
        $file = Configuration::outputDir() . 'console/logs/athenaeum.log';
        if (file_exists($file)) {
            unlink($file);
        }

        parent::_before();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    public function respectsMustThrowExceptionsState()
    {
        $this->expectException(CommandFailure::class);

        $this->forceThrowExceptions = true;

        $this
            ->withoutMockingConsoleOutput()
            ->artisan('test:fail');
    }

    /**
     * @test
     */
    public function handlesException()
    {
        $this->getApplication()->forceThrowExceptions(false);

        $this
            ->artisan('test:fail')
            ->expectsOutput('Test failure...')
            ->assertExitCode(1)
            ->run();
    }
}
