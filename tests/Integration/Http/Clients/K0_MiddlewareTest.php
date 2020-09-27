<?php


namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\Helpers\Dummies\Http\Clients\Middleware\DummyMiddleware;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * K0_MiddlewareTest
 *
 * @group http-clients
 * @group http-clients-k0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class K0_MiddlewareTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    public function extractsMiddlewareFromOptions(string $profile)
    {
        $middleware = [
            DummyMiddleware::class,
            DummyMiddleware::class,
            DummyMiddleware::class,
        ];

        $client = $this
            ->client($profile, ['middleware' => $middleware]);

        $this->assertTrue($client->hasMiddleware(), 'Client missing middleware');
        $this->assertCount(count($middleware), $client->getMiddleware(), 'Incorrect amount of middleware added');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canAddMiddlewareUsingInstance(string $profile)
    {
        $builder = $this
            ->client($profile)
            ->withMiddleware(DummyMiddleware::class);

        $this->assertTrue($builder->hasMiddleware(), 'Client missing middleware');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    public function appliesMiddleware(string $profile)
    {
        $middleware = [
            new DummyMiddleware(),
            new DummyMiddleware(),
            new DummyMiddleware(),
        ];

        $builder = $this
            ->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withMiddleware($middleware);

        $builder->get('/users');

        foreach ($middleware as $processed) {
            $this->assertTrue($processed->hasBeenInvoked(), 'Middleware not invoked');
        }
    }
}
