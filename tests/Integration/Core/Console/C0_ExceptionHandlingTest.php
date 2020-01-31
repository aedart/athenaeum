<?php

namespace Aedart\Tests\Integration\Core\Console;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Console\Commands\Exceptions\CommandFailure;
use Aedart\Tests\TestCases\Console\AthenaeumCoreConsoleTestCase;

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
