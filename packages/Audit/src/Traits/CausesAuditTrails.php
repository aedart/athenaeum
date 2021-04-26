<?php

namespace Aedart\Audit\Traits;

use Aedart\Audit\Models\AuditTrail;
use Aedart\Audit\Models\Concerns\AuditTrailConfiguration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Causes Audit Trails
 *
 * Intended to be used by a "user" model, which is able to cause models
 * to store audit trail entries.
 *
 * @property-read AuditTrail[]|Collection $auditTrails Audit trail entries caused by this user
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Traits
 */
trait CausesAuditTrails
{
    use AuditTrailConfiguration;

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Returns the audit trail entries caused by this user
     *
     * @return HasMany
     */
    public function auditTrails(): HasMany
    {
        return $this->hasMany($this->auditTrailModel());
    }
}
