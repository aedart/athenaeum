<?php


namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\Helpers\Dummies\Http\Clients\Middleware\DummyMiddleware;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * K0_MiddlewareTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-k0',
)]
class K0_MiddlewareTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAddMiddlewareUsingInstance(string $profile)
    {
        $builder = $this
            ->client($profile)
            ->withMiddleware(DummyMiddleware::class);

        $this->assertTrue($builder->hasMiddleware(), 'Client missing middleware');
    }

    /**
     * @param  string  $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
