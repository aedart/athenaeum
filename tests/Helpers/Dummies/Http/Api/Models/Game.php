<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Models;

use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Contracts\ETags\HasEtag;
use Aedart\Database\Models\Concerns\Filtering;
use Aedart\Database\Models\Concerns\Slugs;
use Aedart\ETags\Concerns\EloquentEtag;
use Aedart\Tests\Helpers\Dummies\Http\Api\Factories\GameFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Game
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property int|null $owner_id Foreign key - owner of this game
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Owner|null $owner The owner of this game
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Models
 */
class Game extends Model implements
    Sluggable,
    HasEtag
{
    use Slugs;
    use SoftDeletes;
    use HasFactory;
    use EloquentEtag;
    use Filtering;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [ 'id' ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'owner_id' => 'integer'
    ];

    /*****************************************************************
     * Model Factory
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected static function newFactory()
    {
        return new GameFactory();
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The owner of this game
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}
