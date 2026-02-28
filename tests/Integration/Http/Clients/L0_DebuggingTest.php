<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Messages\Type;
use Aedart\Http\Messages\Traits\HttpSerializerFactoryTrait;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\MessageInterface;
use Symfony\Component\VarDumper\VarDumper;
use Teapot\StatusCode;

/**
 * L0_DebuggingTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-l0',
)]
class L0_DebuggingTest extends HttpClientsTestCase
{
    use HttpSerializerFactoryTrait;

    /**
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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

    /**
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canReadStreamAfterDebugUsingStr(string $profile)
    {
        $mockContent = Json::encode(['message' => 'With pumpkin seeds drink hollandaise sauce.']);
        $mockResponse = new Response(
            StatusCode::OK,
            [],
            $mockContent
        );

        $response = $this
            ->client($profile)
            ->withOption('handler', $this->makeResponseMock([ $mockResponse ]))
            ->debug(function (Type $type, MessageInterface $message) {
                // Simulated var dump, using toString
                $serialized = $this->getHttpSerializerFactory()
                    ->make($message)
                    ->toString();

                ConsoleDebugger::output('SIMULATED DUMP: ' . $serialized);
            })
            ->get('/users');

        // Stream is not rewind and causes, in this context, Json Exception.
        // See https://github.com/aedart/athenaeum/issues/19
        $content = Json::decode($response->getBody()->getContents(), true);

        $this->assertStringContainsString(
            Json::decode($mockContent, true)['message'],
            $content['message'],
            'Incorrect stream handling of request / response content'
        );
    }

    /**
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canReadStreamAfterDebugUsingArr(string $profile)
    {
        $mockContent = Json::encode(['message' => 'With pumpkin seeds drink hollandaise sauce.']);
        $mockResponse = new Response(
            StatusCode::OK,
            [],
            $mockContent
        );

        $response = $this
            ->client($profile)
            ->withOption('handler', $this->makeResponseMock([ $mockResponse ]))
            ->debug(function (Type $type, MessageInterface $message) {
                // Simulated var dump, using toArray
                $serialized = $this->getHttpSerializerFactory()
                    ->make($message)
                    ->toArray();

                ConsoleDebugger::output('SIMULATED DUMP:', $serialized);
            })
            ->get('/users');

        // Stream is not rewind and causes, in this context, Json Exception.
        // See https://github.com/aedart/athenaeum/issues/19
        $content = Json::decode($response->getBody()->getContents(), true);

        $this->assertSame(
            Json::decode($mockContent, true)['message'],
            $content['message'],
            'Incorrect stream handling of request / response content'
        );
    }
}
