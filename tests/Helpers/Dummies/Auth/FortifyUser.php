<?php

namespace Aedart\Tests\Helpers\Dummies\Auth;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Carbon;

/**
 * Fortify User
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon|null $email_verified_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Auth
 */
class FortifyUser extends User
{
    protected $table = 'users';
}
