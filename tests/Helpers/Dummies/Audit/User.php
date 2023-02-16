<?php

namespace Aedart\Tests\Helpers\Dummies\Audit;

use Aedart\Audit\Concerns\AuditTrail;
use Aedart\Contracts\Database\Models\Instantiatable;
use Aedart\Database\Models\Concerns;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Audit
 */
class User extends Authenticatable implements Instantiatable
{
    use Concerns\Instance;
    use AuditTrail;

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
