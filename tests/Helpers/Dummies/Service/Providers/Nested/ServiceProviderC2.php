<?php


namespace Aedart\Tests\Helpers\Dummies\Service\Providers\Nested;

use Aedart\Tests\Helpers\Dummies\Service\Providers\Partials\ProviderState;
use Illuminate\Support\ServiceProvider;

/**
 * Service Provider C 2
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Service\Providers\Nested
 */
class ServiceProviderC2 extends ServiceProvider
{
    use ProviderState;
}
