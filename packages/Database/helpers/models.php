<?php

use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Models\Concerns\Slugs;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('isSluggable')) {
    /**
     * Determine if given model is "sluggable"
     *
     * @param  Model  $model
     *
     * @return bool True if model inherits from {@see Sluggable}, or uses the {@see Slugs} concern.
     */
    function isSluggable(Model $model): bool
    {
        return $model instanceof Sluggable || in_array(Slugs::class, class_uses_recursive($model));
    }
}
