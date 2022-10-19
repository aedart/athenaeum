<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Models;

use Aedart\Tests\Helpers\Dummies\Http\Api\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Address
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @property int $id
 * @property string $street
 * @property string $postal_code
 * @property string $city
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Owner|null $owner The owner of this address
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Models
 */
class Address extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses';

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
        return new AddressFactory();
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Owner of this address
     *
     * @return HasOne
     */
    public function owner(): HasOne
    {
        return $this->hasOne(Owner::class, 'address_id');
    }
}