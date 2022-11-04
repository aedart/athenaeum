<?php

namespace Aedart\Tests\Helpers\Dummies\Database\Models;

use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Model;
use Aedart\Database\Models\Concerns;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Category
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @property int $id Unique identifier
 * @property string $slug Unique string identifier
 * @property string $name Name of category
 * @property string|null $description Evt. description of category
 * @property Carbon $created_at Date and time of when record was created
 * @property Carbon $updated_at Date and time of when record was last updated
 * @property Carbon|null $deleted_at Evt. date and time of when record was soft-deleted
 *
 * @property-read Owner[]|Collection<Owner> $owners Category owners
 * @property-read Product[]|Collection<Product> $products Products in this category
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Database\Models
 */
class Category extends Model implements Sluggable
{
    use Concerns\Slugs;
    use Concerns\Filtering;
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * Category owners
     *
     * @return HasMany
     */
    public function owners(): HasMany
    {
        return $this->hasMany(Owner::class, 'category_id');
    }

    /**
     * Products in this category
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
