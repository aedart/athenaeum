<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * G0_WhenTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-g0',
)]
class G0_WhenTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function appliesCallbackWhenTrue(string $profile)
    {
        $client = $this->client($profile);

        $hasAppliedCallback = false;
        $client->when(true, function (Builder $builder) use (&$hasAppliedCallback) {
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function appliesOtherwiseCallbackWhenFalse(string $profile)
    {
        $client = $this->client($profile);

        $hasAppliedCallback = false;
        $client->when(false, function (Builder $builder) {
            // Do nothing here...
        }, function (Builder $builder) use (&$hasAppliedCallback) {
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function resolvesCallableResultForWhen(string $profile)
    {
        $client = $this->client($profile);

        $result = fn () => true;

        $hasAppliedCallback = false;
        $client->when($result, function (Builder $builder) use (&$hasAppliedCallback) {
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function appliesCallbackUnlessFalse(string $profile)
    {
        $client = $this->client($profile);

        $hasAppliedCallback = false;
        $client->unless(false, function (Builder $builder) use (&$hasAppliedCallback) {
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function appliesOtherwiseCallbackUnlessTrue(string $profile)
    {
        $client = $this->client($profile);

        $hasAppliedCallback = false;
        $client->unless(true, function (Builder $builder) {
            // Do nothing here...
        }, function (Builder $builder) use (&$hasAppliedCallback) {
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function resolvesCallableResultForUnless(string $profile)
    {
        $client = $this->client($profile);

        $result = fn () => false;

        $hasAppliedCallback = false;
        $client->unless($result, function (Builder $builder) use (&$hasAppliedCallback) {
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }
}
