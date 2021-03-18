<?php

namespace Aedart\Acl\Models\Permissions;

use Aedart\Acl\Traits\AclComponentsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Permission Group
 *
 * @property int $id Unique identifier
 * @property string $slug Unique string identifier
 * @property string $name Name of permission group
 * @property string|null $description Evt. description of permission group
 * @property Carbon $created_at Date and time of when record was created
 * @property Carbon $updated_at Date and time of when record was last updated
 * @property Carbon|null $deleted_at Evt. date and time of when record was soft-deleted
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Models\Permissions
 */
class Group extends Model
{
    use AclComponentsTrait;
    use SoftDeletes;

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
        $this->table = $this->aclTable('groups');

        parent::__construct($attributes);
    }
}