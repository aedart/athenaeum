<?php

namespace Aedart\Tests\Integration\Support\Helpers;


use Aedart\Support\Helpers\Auth\AuthFactoryTrait;
use Aedart\Support\Helpers\Auth\AuthTrait;
use Aedart\Support\Helpers\Auth\PasswordBrokerFactoryTrait;
use Aedart\Support\Helpers\Auth\PasswordTrait;
use Aedart\Support\Helpers\Broadcasting\BroadcastFactoryTrait;
use Aedart\Support\Helpers\Broadcasting\BroadcastTrait;
use Aedart\Support\Helpers\Bus\BusTrait;
use Aedart\Support\Helpers\Bus\QueueingBusTrait;
use Aedart\Support\Helpers\Cache\CacheFactoryTrait;
use Aedart\Support\Helpers\Cache\CacheStoreTrait;
use Aedart\Support\Helpers\Cache\CacheTrait;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Console\ArtisanTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Aedart\Support\Helpers\Cookie\CookieTrait;
use Aedart\Testing\Helpers\TraitTester;
use Aedart\Tests\TestCases\Support\LaravelHelpersTestCase;
use \Mockery as m;

/**
 * LaravelSupportHelpersTest
 *
 * @group laravel
 * @group support
 * @group support-helpers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Support\Helpers
 */
class LaravelSupportHelpersTest extends LaravelHelpersTestCase
{
    /*****************************************************************
     * Setup Methods
     ****************************************************************/

    protected function _after()
    {
        // Prevent laravel from stopping, as this just increases
        // the time it takes to execute
        // @see cleanup() inside this test
    }

    /*****************************************************************
     * Helpers and Utils
     ****************************************************************/

    /**
     * @return array
     */
    public function awareOfComponentsProvider()
    {
        return [
            // Auth
            // TODO: Still unable to mock Gate
            // TODO: @see https://github.com/mockery/mockery/issues/861
            //'GateTrait'                       => [ GateTrait::class ],
            'AuthFactoryTrait'                  => [ AuthFactoryTrait::class ],
            'AuthTrait'                         => [ AuthTrait::class ],
            'PasswordBrokerFactoryTrait'        => [ PasswordBrokerFactoryTrait::class ],
            'PasswordTrait'                     => [ PasswordTrait::class ],

            // Broadcasting
            'BroadcastFactoryTrait'             => [ BroadcastFactoryTrait::class ],
            'BroadcastTrait'                    => [ BroadcastTrait::class ],

            // Bus
            'BusTrait'                          => [ BusTrait::class ],
            'QueueingBusTrait'                  => [ QueueingBusTrait::class ],

            // Cache
            'CacheFactoryTrait'                 => [ CacheFactoryTrait::class ],
            'CacheStoreTrait'                   => [ CacheStoreTrait::class ],
            'CacheTrait'                        => [ CacheTrait::class ],

            // Config
            'ConfigTrait'                       => [ ConfigTrait::class ],

            // Console
            'ArtisanTrait'                      => [ ArtisanTrait::class ],

            // Container
            'ContainerTrait'                    => [ ContainerTrait::class ],

            // Cookie
            'CookieTrait'                       => [ CookieTrait::class ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider awareOfComponentsProvider
     *
     * @param string $awareOfTrait
     *
     * @throws \ReflectionException
     */
    public function canInvokeAwareOfMethods(string $awareOfTrait)
    {
        // Assert getter and setter methods
        $this->assertTraitMethods($awareOfTrait, null, null, false);

        // Assert a default method
        $tester = new TraitTester($this, $awareOfTrait, null);
        $getMethod = $tester->getPropertyMethodName();
        $mock = $tester->getTraitMock();

        $value = $mock->$getMethod();
        $this->assertNotNull($value, 'Default value is not set. Please check your Laravel services');
    }

    /**
     * @test
     *
     * depends canInvokeTraitMethods
     */
    public function cleanup()
    {
        $this->stopApplication();
        m::close();
    }
}
