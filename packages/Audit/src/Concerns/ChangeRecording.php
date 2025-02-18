<?php

namespace Aedart\Audit\Concerns;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Models\AuditTrail;
use Aedart\Audit\Observers\ModelObserver;
use Aedart\Contracts\Audit\Types;
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Models\Concerns\Slugs;
use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

/**
 * Concerns Model Change Recoding
 *
 * Intended to be used by models that must keep an audit trail of their changes.
 *
 * @property-read AuditTrail[]|Collection $recordedChanges Audit trail entries for this model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Concerns
 */

trait ChangeRecording
{
    use AuditTrailConfig;

    /**
     * The attributes that should be hidden for Audit Trail Entries
     *
     * @see attributesToHideForAudit
     * @see makeHiddenForAudit
     * @see getHiddenForAudit
     *
     * @var string[]
     */
    protected array|null $hiddenInAuditTrail = null;

    /**
     * State whether "model has changed" events should
     * be skipped (e.g. skip recording changes)
     *
     * @var bool
     */
    protected bool $skipNextRecording = false;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * Boots has audit trail functionality for this model
     *
     * @return void
     */
    public static function bootChangeRecording()
    {
        // Obtain class path to observer. Note: since we are in a static method,
        // we need to obtain this from the configuration via a facade.
        $observer = Config::get('audit-trail.observer', ModelObserver::class);
        static::observe($observer);
    }

    /*****************************************************************
     * Recording
     ****************************************************************/

    /**
     * Record a new change for this model
     *
     * @param string $type Name of "event" or "action" type that is recorded.
     * @param array|null $original [optional] Original data (attributes) before change occurred. Defaults to model's original data.
     * @param array|null $changed [optional] Changed data (attributes) after change occurred. Defaults to model's changed data.
     * @param string|null $message [optional]
     * @param Authenticatable|Model|null $user [optional] Defaults to current authenticated user.
     * @param DateTimeInterface|string|null $performedAt [optional] Defaults to "now".
     *
     * @return self
     */
    public function recordNewChange(
        string $type,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
        Authenticatable|Model|null $user = null,
        DateTimeInterface|string|null $performedAt = null
    ): static {
        $user = $user ?? Auth::user();

        ModelHasChanged::dispatch($this, $user, $type, $original, $changed, $message, $performedAt);

        return $this;
    }

    /**
     * Determine if this model must use slugs as an identifier
     * for when recording audit trail entries
     *
     * @return bool
     */
    public function useSlugAsIdentifier(): bool
    {
        return $this instanceof Sluggable || in_array(Slugs::class, class_uses_recursive($this));
    }

    /*****************************************************************
     * Original & Changed data
     ****************************************************************/

    /**
     * Returns the original data (attributes) to be saved
     * in Audit Trail Entry
     *
     * @param string $type Event type
     *
     * @return array|null
     */
    public function originalData(string $type): array|null
    {
        if ($this->shouldOmitDataFor($type)) {
            return null;
        }

        return $this->formatOriginalData(
            $this->filterAuditData($this->getOriginal()),
            $type
        );
    }

    /**
     * Formats the original data (attributes) to be saved in
     * Audit Trail Entry
     *
     * @see originalData
     *
     * @param array|null $filtered The filtered original data (if any)
     * @param string $type Event type
     *
     * @return array|null
     */
    public function formatOriginalData(array|null $filtered, string $type): array|null
    {
        return $filtered;
    }

    /**
     * Returns the changed data (attributes) to be saved
     * in Audit Trail Entry
     *
     * @param string $type Event type
     *
     * @return array|null
     */
    public function changedData(string $type): array|null
    {
        if ($this->shouldOmitDataFor($type)) {
            return null;
        }

        // Tip: You can use "getAttributes()", if you wish to store all
        // attributes into the Audit Trail entry.
        // @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::getAttributes
        //
        // By default, we only save the changed (dirty) attributes.

        return $this->formatChangedData(
            $this->filterAuditData($this->getDirty()),
            $type
        );
    }

    /**
     * Formats the changed data (attributes) to be saved in
     * Audit Trail Entry
     *
     * @see changedData
     *
     * @param array|null $filtered The filtered changed data (if any)
     * @param string $type Event type
     *
     * @return array|null
     */
    public function formatChangedData(array|null $filtered, string $type): array|null
    {
        return $filtered;
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
    public function filterAuditData(array|null $attributes = null): array|null
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
        if (!isset($this->hiddenInAuditTrail)) {
            $this->makeHiddenForAudit(
                $this->attributesToHideForAudit()
            );
        }

        return $this->hiddenInAuditTrail;
    }

    /**
     * Mark given attributes hidden for Audit Trail Entries
     *
     * @param  string|string[]|null  $attributes
     *
     * @return self
     */
    public function makeHiddenForAudit(array|string|null $attributes): static
    {
        $attributes = is_array($attributes)
            ? $attributes
            : func_get_args();

        $this->hiddenInAuditTrail = array_merge(
            $this->hiddenInAuditTrail ?? [],
            $attributes
        );

        return $this;
    }

    /**
     * Returns list of attribute names that are NOT to be included
     * in Audit Trail Entries
     *
     * @see makeHiddenForAudit
     *
     * @return string[]
     */
    public function attributesToHideForAudit(): array
    {
        // Use this method to hide attributes from Audit Trail entry
        return $this->auditTimestampAttributes();
    }

    /**
     * Returns the model timestamp attribute names
     *
     * @return string[]
     */
    public function auditTimestampAttributes(): array
    {
        $attributes = [
            $this->getCreatedAtColumn(),
            $this->getUpdatedAtColumn(),
        ];

        if (method_exists($this, 'getDeletedAtColumn')) {
            $attributes[] = $this->getDeletedAtColumn();
        }

        return $attributes;
    }

    /**
     * Determine whether data (attributes) should be omitted for
     * the given event type or not
     *
     * @param string $type
     *
     * @return bool
     */
    public function shouldOmitDataFor(string $type): bool
    {
        $skipOn = [
            Types::DELETED,
            Types::FORCE_DELETED,
            Types::RESTORED
        ];

        return in_array($type, $skipOn);
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
    public function getAuditTrailMessage(string $type): string|null
    {
        return null;
    }

    /*****************************************************************
     * Skip Audit Trail Recording
     ****************************************************************/

    /**
     * Skip recording next change
     *
     * @param bool $skip [optional]
     *
     * @return self
     */
    public function skipRecordingNextChange(bool $skip = true): static
    {
        $this->skipNextRecording = $skip;

        return $this;
    }

    /**
     * Opposite of skip recording next change
     *
     * @see skipRecordingNextChange
     *
     * @param bool $record [optional]
     *
     * @return self
     */
    public function recordNextChange(bool $record = true): static
    {
        return $this->skipRecordingNextChange(!$record);
    }

    /**
     * Determine whether next change should be recorded or not
     *
     * @return bool
     */
    public function mustRecordNextChange(): bool
    {
        return !$this->skipNextRecording;
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Returns of recorded audit trail entries for this model
     *
     * @return MorphMany
     */
    public function recordedChanges(): MorphMany
    {
        return $this->morphMany($this->auditTrailModel(), 'auditable');
    }
}
