<?php

namespace Aedart\Audit\Providers;

use Aedart\Audit\Subscribers\AuditTrailEventSubscriber;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Illuminate\Support\ServiceProvider;

/**
 * Audit Trail Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Providers
 */
class AuditTrailServiceProvider extends ServiceProvider
{
    use ConfigTrait;
    use DispatcherTrait;

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/audit-trail.php' => config_path('audit-trail.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations')
        ], 'migrations');

        $this->registerEventListener();
    }

    /**
     * Registers the "model has changed" event listener
     */
    protected function registerEventListener()
    {
        $subscriber = $this->getConfig()->get('audit-trail.subscriber', AuditTrailEventSubscriber::class);
        $this->getDispatcher()->subscribe($subscriber);
    }
}
