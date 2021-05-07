<?php

namespace Aedart\Audit\Providers;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Listeners\RecordAuditTrailEntry;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Illuminate\Support\ServiceProvider;

/**
 * Audit Trail Service Provider
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
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
        $listener = $this->getConfig()->get('audit-trail.listener', RecordAuditTrailEntry::class);

        $this->getDispatcher()->listen(ModelHasChanged::class, $listener);
    }
}
