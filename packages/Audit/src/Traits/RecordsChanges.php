<?php


namespace Aedart\Audit\Traits;

use Aedart\Audit\Concerns\ChangeRecording;
use Aedart\Audit\Models\AuditTrail;
use Illuminate\Database\Eloquent\Collection;

/**
 * @deprecated Since 7.0, replaced by {@see \Aedart\Audit\Concerns\ChangeRecording}
 *
 * Records Changes
 *
 * Intended to be used by models that must keep an audit trail of its
 * changes.
 *
 * @property-read AuditTrail[]|Collection $recordedChanges Audit trail entries for this model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Traits
 */
trait RecordsChanges
{
    use ChangeRecording;
}
