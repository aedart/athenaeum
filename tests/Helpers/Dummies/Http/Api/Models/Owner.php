<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Models;

use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Models\Concerns\Slugs;
use Aedart\Tests\Helpers\Dummies\Http\Api\Factories\OwnerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Owner
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @property int $id
 * @property string $name
 * @property int|null $address_id Foreign Key - Owner's address
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Address|null $address Owner's address
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Models
 */
class Owner extends Model implements Sluggable
{
    use Slugs;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'owners';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [ 'id' ];

    /**
     * Name of slug key
     *
     * @var string
     */
    protected string $slugKey = 'name';

    /*****************************************************************
     * Model Factory
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected static function newFactory()
    {
        return new OwnerFactory();
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Owner's address
     *
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
