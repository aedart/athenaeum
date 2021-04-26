<?php


namespace Aedart\Audit\Traits;


use Aedart\Audit\Models\AuditTrail;
use Aedart\Audit\Models\Concerns\AuditTrailConfiguration;
use Aedart\Audit\Observers\ModelObserver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Config;

/**
 * Has Audit Trail
 *
 * Intended to be used by models that must keep an audit trail of it's
 * changes.
 *
 * @property-read AuditTrail[]|Collection $auditTrail Audit trail entries for this model
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Traits
 */
trait HasAuditTrail
{
    use AuditTrailConfiguration;

    /**
     * Boots has audit trail functionality for this model
     *
     * @return void
     */
    static public function bootHasAuditTrail()
    {
        // Obtain class path to observer. Note: since we are in a static method,
        // we need to obtain this from the configuration via a facade.
        $observer = Config::get('audit-trail.observer', ModelObserver::class);
        static::observe($observer);
    }

    /*****************************************************************
     * Audit Trail Message
     ****************************************************************/

    /**
     * Returns evt. message to be stored in Audit Trail Entry, for
     * the given entry type
     *
     * @param string $type Audit Trail Entry type, e.g. created, updated, deleted... etc
     *
     * @return string|null
     */
    public function getAuditTrailMessage(string $type): ?string
    {
        return null;
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Returns audit trail entries for this model
     *
     * @return MorphMany
     */
    public function auditTrail(): MorphMany
    {
        return $this->morphMany($this->auditTrailModel(), 'auditable');
    }
}