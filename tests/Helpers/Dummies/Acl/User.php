<?php

namespace Aedart\Tests\Helpers\Dummies\Acl;

use Aedart\Acl\Traits\HasRoles;
use Aedart\Contracts\Database\Models\Instantiatable;
use Aedart\Database\Models\Concerns;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Acl
 */
class User extends Authenticatable implements Instantiatable
{
    use Concerns\Instance;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];
}
