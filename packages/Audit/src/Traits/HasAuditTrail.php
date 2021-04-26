<?php


namespace Aedart\Audit\Traits;


use Aedart\Audit\Models\AuditTrail;
use Aedart\Audit\Models\Concerns\AuditTrailConfiguration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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