<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Models;

use Aedart\Contracts\ETags\HasEtag;
use Aedart\ETags\Concerns\EloquentEtag;
use Aedart\Redmine\Collections\Collection;
use Aedart\Tests\Helpers\Dummies\Http\Api\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * User
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Role[]|Collection<Role>|null $roles User's roles
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Models
 */
class User extends Model implements HasEtag
{
    use HasFactory;
    use EloquentEtag;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [ 'id' ];

    /*****************************************************************
     * Model Factory
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected static function newFactory()
    {
        return new UserFactory();
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * User's roles
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
