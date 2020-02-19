<?php

namespace Aedart\Tests\Helpers\Dummies\Service\Providers;

use Aedart\Tests\Helpers\Dummies\Box;
use Aedart\Tests\Helpers\Dummies\Contracts\Box as BoxInterface;
use Aedart\Tests\Helpers\Dummies\Events\TestEvent;
use Aedart\Tests\Helpers\Dummies\Service\Providers\Partials\ProviderState;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Deferred Service Provider
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Service\Providers
 */
class DeferredServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use ProviderState {
        register as traitRegister;
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->bind(BoxInterface::class, fn () => new Box());

        $this->traitRegister();
    }

    /**
     * @inheritdoc
     */
    public function when()
    {
        return [
            TestEvent::class
        ];
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return [
            BoxInterface::class
        ];
    }
}
