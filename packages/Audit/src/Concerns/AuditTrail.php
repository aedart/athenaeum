<?php

namespace Aedart\Audit\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Concerns Model Audit Trail
 *
 * Intended to be used by a "user" model, which is able to cause models
 * to store audit trail entries.
 *
 * @property-read \Aedart\Audit\Models\AuditTrail[]|Collection $auditTrail Audit trail entries caused by this user
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Concerns
 */
trait AuditTrail
{
    use AuditTrailConfig;

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Returns the audit trail entries caused by this user
     *
     * @return HasMany
     */
    public function auditTrail(): HasMany
    {
        return $this->hasMany($this->auditTrailModel());
    }
}
