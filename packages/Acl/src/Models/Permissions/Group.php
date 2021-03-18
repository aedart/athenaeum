<?php

namespace Aedart\Acl\Models\Permissions;

use Aedart\Acl\Traits\AclComponentsTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Permission Group
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Models\Permissions
 */
class Group extends Model
{
    use AclComponentsTrait;

    /**
     * @inheritdoc
     */
    public function __construct(array $attributes = [])
    {
        $this->table = $this->aclTable('groups');

        parent::__construct($attributes);
    }
}