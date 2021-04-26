<?php


namespace Aedart\Audit\Traits;

use Aedart\Audit\Models\AuditTrail;
use Aedart\Audit\Models\Concerns\AuditTrailConfiguration;
use Aedart\Audit\Observers\ModelObserver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Config;

/**
 * Records Changes
 *
 * Intended to be used by models that must keep an audit trail of it's
 * changes.
 *
 * @property-read AuditTrail[]|Collection $recordChanges Audit trail entries for this model
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Traits
 */
trait RecordsChanges
{
    use AuditTrailConfiguration;

    /**
     * The attributes that should be hidden for Audit Trail Entries
     *
     * @var string[]
     */
    protected $hiddenInAuditTrail = [];

    /**
     * Boots has audit trail functionality for this model
     *
     * @return void
     */
    public static function bootHasAuditTrail()
    {
        // Obtain class path to observer. Note: since we are in a static method,
        // we need to obtain this from the configuration via a facade.
        $observer = Config::get('audit-trail.observer', ModelObserver::class);
        static::observe($observer);
    }

    /*****************************************************************
     * Original & Changed data
     ****************************************************************/

    /**
     * Returns the original data (attributes) to be saved
     * in Audit Trail Entry
     *
     * @return array|null
     */
    public function originalData(): ?array
    {
        return $this->filterAuditData($this->getOriginal());
    }

    /**
     * Returns the changed data (attributes) to be saved
     * in Audit Trail Entry
     *
     * @return array|null
     */
    public function changedData(): ?array
    {
        return $this->filterAuditData($this->getAttributes());
    }

    /**
     * Filters Audit Trail data
     *
     * Method removes any attribute that are not intended to be
     * part of an Audit Trail Entry.
     *
     * @see getHiddenForAudit
     * @see \Illuminate\Database\Eloquent\Concerns\HidesAttributes::getHidden
     *
     * @param array|null $attributes [optional]
     *
     * @return array|null
     */
    public function filterAuditData(?array $attributes = null): ?array
    {
        if (empty($attributes)) {
            return null;
        }

        return collect($attributes)

            // Filter off attributes not to be included in
            // Audit Trail Entry
            ->except($this->getHiddenForAudit())

            // Filter off regular hidden attributes
            ->except($this->getHidden())

            ->toArray();
    }

    /**
     * Get attributes that are hidden for Audit Trail Entries
     *
     * @return string[]
     */
    public function getHiddenForAudit(): array
    {
        return $this->hiddenInAuditTrail;
    }

    /**
     * Mark given attributes hidden for Audit Trail Entries
     *
     * @param string|string[]|null $attributes
     *
     * @return self
     */
    public function makeHiddenForAudit($attributes)
    {
        $attributes = is_array($attributes)
            ? $attributes
            : func_get_args();

        $this->hiddenInAuditTrail = array_merge(
            $this->hiddenInAuditTrail,
            $attributes
        );

        return $this;
    }

    /*****************************************************************
     * Audit Trail Message
     ****************************************************************/

    /**
     * Returns evt. message to be stored in Audit Trail Entry, for
     * the given entry type
     *
     * NOTE: This method is invoked BEFORE "model has changed" event is
     * dispatched. You can therefore use this method to access resources
     * that are NOT necessarily available during event listener processing.
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
    public function recordChanges(): MorphMany
    {
        return $this->morphMany($this->auditTrailModel(), 'auditable');
    }
}
