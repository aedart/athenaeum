<?php

namespace Aedart\Acl\Models;

use Aedart\Acl\Traits\AclComponentsTrait;
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Models\Concerns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Role
 *
 * @property int $id Unique identifier
 * @property string $slug Unique string identifier
 * @property string $name Name of role
 * @property string|null $description Evt. description of role
 * @property Carbon $created_at Date and time of when record was created
 * @property Carbon $updated_at Date and time of when record was last updated
 * @property Carbon|null $deleted_at Evt. date and time of when record was soft-deleted
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Models
 */
class Role extends Model implements Sluggable
{
    use AclComponentsTrait;
    use SoftDeletes;
    use Concerns\Slugs;

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
        $this->table = $this->aclTable('roles');

        parent::__construct($attributes);
    }

    /*****************************************************************
     * Relations
     ****************************************************************/
}