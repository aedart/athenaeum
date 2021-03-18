<?php

namespace Aedart\Acl\Models;

use Aedart\Acl\Models\Permissions\Group;
use Aedart\Acl\Traits\AclComponentsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Permission
 *
 * @property int $id Unique identifier
 * @property int $group_id Foreign key to permission group this belongs to
 * @property string $slug Unique string identifier
 * @property string $name Name of permission
 * @property string|null $description Evt. description of permission
 * @property Carbon $created_at Date and time of when record was created
 * @property Carbon $updated_at Date and time of when record was last updated
 *
 * @property Group $group The group this permission belongs to
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Models
 */
class Permission extends Model
{
    use AclComponentsTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [ 'group' ];

    /**
     * @inheritdoc
     */
    public function __construct(array $attributes = [])
    {
        $this->table = $this->aclTable('permissions');

        parent::__construct($attributes);
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The permission group this permission belongs to
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo($this->aclPermissionsGroupModel());
    }
}