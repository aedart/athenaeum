<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;

/**
 * G0_WhenTest
 *
 * @group http-clients
 * @group http-clients-g0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class G0_WhenTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function appliesCallbackWhenTrue(string $profile)
    {
        $client = $this->client($profile);

        $hasAppliedCallback = false;
        $client->when(true, function(Builder $builder) use(&$hasAppliedCallback){
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function appliesOtherwiseCallbackWhenFalse(string $profile)
    {
        $client = $this->client($profile);

        $hasAppliedCallback = false;
        $client->when(false, function(Builder $builder){
            // Do nothing here...
        }, function(Builder $builder) use(&$hasAppliedCallback){
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function appliesCallbackUnlessFalse(string $profile)
    {
        $client = $this->client($profile);

        $hasAppliedCallback = false;
        $client->unless(false, function(Builder $builder) use(&$hasAppliedCallback){
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function appliesOtherwiseCallbackUnlessTrue(string $profile)
    {
        $client = $this->client($profile);

        $hasAppliedCallback = false;
        $client->unless(true, function(Builder $builder){
            // Do nothing here...
        }, function(Builder $builder) use(&$hasAppliedCallback){
            $hasAppliedCallback = true;
        });

        $this->assertTrue($hasAppliedCallback);
    }
}