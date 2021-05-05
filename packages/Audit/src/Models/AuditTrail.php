<?php

namespace Aedart\Audit\Models;

use Aedart\Audit\Models\Concerns as AuditTrailConcerns;
use Aedart\Database\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

/**
 * Audit Trail
 *
 * @property int $id Unique identifier
 * @property int|null $user_id The user that caused this action, event or data change
 * @property string $auditable_type The auditable model type
 * @property int $auditable_id The auditable model id - soft foreign-key
 * @property string $type Action or event type, e.g. created, updated... etc
 * @property string|null $message Eventual description or message about why action or event was caused
 * @property array|null $original_data The original data, before any changes were made
 * @property array|null $changed_data Data after changes have been made
 * @property Carbon $performed_at Date and time of when action or event happened (when user caused a action...)
 * @property Carbon $created_at Date and time of when record was created
 *
 * @property-read Model|Authenticatable|null $user The user that caused audit trail entry
 * @property-read Model $auditable The parent auditable model
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Models
 */
class AuditTrail extends Model
{
    use AuditTrailConcerns\AuditTrailConfiguration;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'original_data' => 'array',
        'changed_data' => 'array',
        'performed_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * @inheritdoc
     */
    public function __construct(array $attributes = [])
    {
        $this->table = $this->auditTrailTable();

        // Disable timestamps - we manually insert created_at timestamp
        $this->timestamps = false;

        parent::__construct($attributes);
    }

    /**
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically set the "created_at" timestamp
        static::creating(function (self $model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Returns the parent auditable model
     *
     * @return MorphTo
     */
    public function auditable(): MorphTo
    {
        return $this
            ->morphTo()
            ->withoutGlobalScope(SoftDeletingScope::class);
    }

    /**
     * The user that caused this audit trail entry
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo($this->auditTrailUserModel());
    }
}
