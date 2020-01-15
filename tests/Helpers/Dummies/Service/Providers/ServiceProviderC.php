<?php


namespace Aedart\Tests\Helpers\Dummies\Service\Providers;

use Aedart\Tests\Helpers\Dummies\Service\Providers\Nested\ServiceProviderC1;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Nested\ServiceProviderC2;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Nested\ServiceProviderC3;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Partials\ProviderState;
use Illuminate\Support\AggregateServiceProvider;

/**
 * Service Provider C (Aggregate service provider)
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Service\Providers
 */
class ServiceProviderC extends AggregateServiceProvider
{
    use ProviderState {
        register as registerTrait;
    }

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ServiceProviderC1::class,
        ServiceProviderC2::class,
        ServiceProviderC3::class
    ];

    public function register()
    {
        parent::register();

        $this->registerTrait();
    }
}
