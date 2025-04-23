<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use GuzzleHttp\Psr7\Response;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode;

/**
 * L1_LoggingTest
 *
 * @group http-clients
 * @group http-clients-l1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-l1',
)]
class L1_LoggingTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        $fs = new Filesystem();
        $fs->cleanDirectory($this->logFileDirectory());
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns location to where a log file should be stored.
     *
     * @return string
     */
    public function logFileDirectory(): string
    {
        return Configuration::outputDir() . 'http/clients';
    }

    /**
     * Returns full path to where log-file is located.
     *
     * @return string
     */
    public function logFilePath(): string
    {
        return $this->logFileDirectory() . '/app.log';
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/


    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canLogRequestAndResponse(string $profile)
    {
        $this
            ->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->where('created_at', '2020')
            ->log()
            ->get('/users');

        $logFile = $this->logFilePath();
        $this->assertFileExists($logFile, 'Log file not created');

        $content = file_get_contents($logFile);
        $this->assertStringContainsString('Request', $content, 'Log file does not contain request');
        $this->assertStringContainsString('Response', $content, 'Log file does not contain response');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canLogUsingCustomCallback(string $profile)
    {
        $callbackInvoked = false;

        $this
            ->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->where('created_at', '2020')
            ->log(function () use (&$callbackInvoked) {
                $callbackInvoked = true;
            })
            ->get('/users');

        $this->assertTrue($callbackInvoked, 'Custom log callback not invoked');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function logsBeforeResponseExpectations(string $profile)
    {
        $callbackOrder = [];

        $this
            ->client($profile)
            ->withOption('handler', $this->makeResponseMock([ new Response(StatusCode::INTERNAL_SERVER_ERROR) ]))
            ->expect(StatusCode::OK, function () use (&$callbackOrder) {
                $callbackOrder[] = 'expectation';
            })
            ->log(function () use (&$callbackOrder) {
                $callbackOrder[] = 'log';
            })
            ->get('/users');

        ConsoleDebugger::output($callbackOrder);

        // Debug should be invoked twice (for request and then for response)
        $this->assertSame([ 'log', 'log', 'expectation' ], $callbackOrder, 'Log was not invoked before expectation callback!');
    }
}
