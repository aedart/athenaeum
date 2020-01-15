<?php

namespace Aedart\Tests\Helpers\Dummies\Service\Providers;

use Aedart\Tests\Helpers\Dummies\Service\Providers\Partials\ProviderState;
use Illuminate\Support\ServiceProvider;

/**
 * Service Provider A
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Service\Providers
 */
class ServiceProviderA extends ServiceProvider
{
    use ProviderState;
}
