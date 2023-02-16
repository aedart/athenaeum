<?php

namespace Aedart\Audit\Listeners;

use Aedart\Audit\Concerns\AuditTrailConfig;
use Aedart\Utils\Json;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;
use JsonException;

/**
 * Records Entries
 *
 * Base abstraction for audit trail event listeners
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Listeners
 */
abstract class RecordsEntries implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use AuditTrailConfig;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public int $tries;

    /**
     * Determine if a user exists with the given id
     *
     * @param string|int|null $id
     *
     * @return bool
     */
    protected function userExists(string|int|null $id): bool
    {
        if (!isset($id)) {
            return false;
        }

        $model = $this->auditTrailUserModelInstance();

        return $model
            ->newQuery()
            ->where($model->getKeyName(), $id)
            ->exists();
    }

    /**
     * Configure queue settings for this listener
     *
     * @return self
     */
    protected function configureQueueSettings(): static
    {
        $config = Config::get('audit-trail.queue', []);

        $this->connection = $config['connection'] ?? 'sync';
        $this->queue = $config['queue'] ?? 'default';
        $this->delay = $config['delay'] ?? null;
        $this->tries = $config['retries'] ?? 1;

        return $this;
    }

    /**
     * Convert given data to json
     *
     * @param  array|null  $data  [optional]
     *
     * @return string|null
     *
     * @throws JsonException
     */
    protected function convertToJson(?array $data = null): ?string
    {
        if (!isset($data)) {
            return null;
        }

        return Json::encode($data);
    }
}
