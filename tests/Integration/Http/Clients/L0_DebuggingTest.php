<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\VarDumper\VarDumper;
use Teapot\StatusCode;

/**
 * L0_DebuggingTest
 *
 * @group http-clients
 * @group http-clients-l0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class L0_DebuggingTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canDebugRequestAndResponse(string $profile)
    {
        // Amount of times debug method has been invoked.
        $debugInvoked = 0;

        // Overwrite Symfony Var Dumper's handler (to avoid unwanted behaviour)
        $originalHandler = VarDumper::setHandler(function ($context) use (&$debugInvoked) {
            ConsoleDebugger::output($context);
            $debugInvoked++;
        });

        $this
            ->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->where('created_at', '2020')
            ->debug()
            ->get('/users');

        // Restore Symfony Var Dumper's handler
        VarDumper::setHandler($originalHandler);

        $this->assertSame(2, $debugInvoked, 'Incorrect amount of debug method invoked.');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canDumpAndDie(string $profile)
    {
        // Amount of times debug method has been invoked.
        $ddInvoked = 0;

        // Overwrite Symfony Var Dumper's handler (to avoid unwanted behaviour)
        $originalHandler = VarDumper::setHandler(function ($context) use (&$ddInvoked) {
            ConsoleDebugger::output($context);
            $ddInvoked++;
        });

        $this
            ->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->where('created_at', '2020')
            ->dd()
            ->get('/users');

        // Restore Symfony Var Dumper's handler
        VarDumper::setHandler($originalHandler);

        // NOTE: Since we overwrite the handler, the middleware continues and the script
        // does not exist. This means that the dd() method should be invoked twice, during
        // this test. If dd() was invoked without handler overwrite, the script would have
        // exited before ever reaching this assert!
        $this->assertGreaterThanOrEqual(1, $ddInvoked, 'Incorrect amount of dd method invoked.');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canDebugUsingCustomCallback(string $profile)
    {
        $callbackInvoked = false;

        $this
            ->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->where('created_at', '2020')
            ->debug(function () use (&$callbackInvoked) {
                $callbackInvoked = true;
            })
            ->get('/users');

        $this->assertTrue($callbackInvoked, 'Custom debug not invoked');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canDumpAndDieUsingCustomCallback(string $profile)
    {
        $callbackInvoked = false;

        $this
            ->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->where('created_at', '2020')
            ->dd(function () use (&$callbackInvoked) {
                $callbackInvoked = true;
            })
            ->get('/users');

        $this->assertTrue($callbackInvoked, 'Custom dump & die not invoked');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    public function debugsBeforeResponseExpectations(string $profile)
    {
        $callbackOrder = [];

        $this
            ->client($profile)
            ->withOption('handler', $this->makeResponseMock([ new Response(StatusCode::INTERNAL_SERVER_ERROR) ]))
            ->expect(StatusCode::OK, function () use (&$callbackOrder) {
                $callbackOrder[] = 'expectation';
            })
            ->debug(function () use (&$callbackOrder) {
                $callbackOrder[] = 'debug';
            })
            ->get('/users');

        ConsoleDebugger::output($callbackOrder);

        // Debug should be invoked twice (for request and then for response)
        $this->assertSame([ 'debug', 'debug', 'expectation' ], $callbackOrder, 'Debug was not invoked before expectation callback!');
    }
}
