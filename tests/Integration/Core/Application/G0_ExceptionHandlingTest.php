<?php

namespace Aedart\Tests\Integration\Core\Application;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\IntegrationTestCase;
use Codeception\Configuration;
use Illuminate\Filesystem\Filesystem;

/**
 * G0_ExceptionHandling
 *
 * @group application
 * @group application-g0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Application
 */
class G0_ExceptionHandlingTest extends IntegrationTestCase
{
    /*****************************************************************
     * To test the custom exception handling, we invoke various
     * applications as external processes, so that they do not
     * cause unintended test-failures, when errors and exceptions
     * are encountered.
     *
     * The applications are found in the following path:
     * "_data/exceptions/"
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();

        // Remove entire output dir for these tests
        $fs = new Filesystem();
        if ($fs->exists($this->outputPath())) {
            $fs->deleteDirectories($this->outputPath());
            $fs->makeDirectory($this->outputPath(), 0755, true, true);
        }
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns location of output directory for these tests
     *
     * @return string
     */
    protected function outputPath(): string
    {
        return Configuration::outputDir() . 'exceptions/';
    }

    /**
     * Returns location of where external applications are
     * located.
     *
     * @return string
     */
    protected function applicationPath(): string
    {
        return Configuration::dataDir() . 'exceptions/';
    }

    /**
     * Invoke external application
     *
     * @param string $application Filename without .php
     *
     * @return string Application output
     */
    protected function invokeApp(string $application = 'normal'): string
    {
        // Setup command and output
        $path = $this->applicationPath();
        $application .= '.php';
        $cmd = 'php ' . $path . $application . ' 2>&1';

        $output = [];
        $exitCode = 0;

        // Invoke external application
        @exec($cmd, $output, $exitCode);

        // Transform output to a string
        $output = implode(PHP_EOL, $output);

        ConsoleDebugger::output($output);

        // Finally, return the output
        return $output;
    }

    /**
     * Assert that a given log entry has been made
     *
     * @param string $expected
     * @param string $failMsg [optional]
     */
    protected function assertLogFileContainers(string $expected, string $failMsg = 'invalid log entry')
    {
        $logFile = $this->outputPath() . 'storage/logs/laravel.log';
        $this->assertFileExists($logFile, 'Log file not created');

        $content = file_get_contents($logFile);
        $this->assertStringContainsString($expected, $content, $failMsg);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    public function canLogSingleEntryWithoutFailure()
    {
        $output = $this->invokeApp('normal');

        $this->assertStringContainsString('ok', $output, 'incorrect output');
        $this->assertLogFileContainers('normal application works');
    }

    /**
     * @test
     */
    public function handlesErrors()
    {
        $output = $this->invokeApp('handles-errors');

        $expected = 'Custom PHP Error captured';

        $this->assertStringContainsString($expected, $output, 'incorrect output');
        $this->assertLogFileContainers($expected);
    }

    /**
     * @test
     */
    public function handlesExceptions()
    {
        $output = $this->invokeApp('handles-exceptions');

        $expected = 'Exception captured';

        $this->assertStringContainsString($expected, $output, 'incorrect output');
        $this->assertLogFileContainers($expected);
    }

    /**
     * @test
     */
    public function handlesExceptionsDuringShutdown()
    {
        $output = $this->invokeApp('handles-shutdown');

        $expected = 'Shutdown error captured';

        $this->assertStringContainsString($expected, $output, 'incorrect output');
        $this->assertLogFileContainers($expected);
    }

    /**
     * @test
     */
    public function terminatesGracefullyWhenExceptionIsHandled()
    {
        // This test has two aspects:
        //
        // a) If exception is handled, application should be allowed to continue
        //    and terminate (if run() method is used with callback...)
        //
        // b) Exception is allowed to be passed on to the next handler registered,
        //    if the first didn't handle it.

        $output = $this->invokeApp('terminates-gracefully');

        $this->assertStringContainsString('special exception handled', $output, 'incorrect output');
        $this->assertStringContainsString('Terminating...', $output, 'incorrect output');
    }

    /**
     * @test
     */
    public function handlesExceptionHandlingFailure()
    {
        $output = $this->invokeApp('fails-exception-handling');

        $this->assertStringContainsString('Exception Handler failure', $output, 'incorrect output');
        $this->assertLogFileContainers('CRITICAL: Exception Handler failure');
    }
}
