<?php

namespace Aedart\Tests\Integration\Core\Console;

use Aedart\Tests\Helpers\Dummies\Console\Commands\Exceptions\CommandFailure;
use Aedart\Tests\TestCases\Console\AthenaeumCoreConsoleTestCase;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use PHPUnit\Framework\Attributes\Test;

/**
 * C0_ExceptionHandlingTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Core\Console
 */
#[Group(
    'application',
    'application-console',
    'application-console-c0',
)]
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

    #[Test]
    public function respectsMustThrowExceptionsState()
    {
        $this->expectException(CommandFailure::class);

        $this->forceThrowExceptions = true;

        $this
            ->withoutMockingConsoleOutput()
            ->artisan('test:fail');
    }

    #[Test]
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
