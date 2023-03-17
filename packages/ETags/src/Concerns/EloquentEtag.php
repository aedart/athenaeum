<?php

namespace Aedart\ETags\Concerns;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Illuminate\Support\Carbon;

/**
 * Concerns Eloquent Etag
 *
 * Able to make new or obtain existing Etag representation of Eloquent model.
 * (Concern intended for Eloquent Models only!)
 *
 * @see \Aedart\Contracts\ETags\HasEtag
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Concerns
 */
trait EloquentEtag
{
    use MakesEtags;

    /**
     * In-memory cache of this Eloquent model's etag(s)
     *
     * @var ETag[]
     */
    protected array $cachedEtags = [];

    /**
     * Returns ETag that represents this component
     *
     * @param  bool  $weak  [optional] When true, ETag is flagged as "weak",
     *                      indented to be used for "weak comparison" (E.g. If-None-Match Http header comparison).
     *                      When false, ETag is not flagged as "weak",
     *                      intended to be used for "strong comparison" (E.g. If-Match Http header comparison).
     * @param  bool  $force  [optional] When true then a new ETag instance is returned.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag
     */
    public function getEtag(bool $weak = true, bool $force = false): ETag
    {
        // When not forced, determine if Eloquent model "is clean". If so,
        // return cached etag, if one exists for the requested "weak" or
        // "strong" flag. Otherwise, create a new etag.

        if (!$force && $this->canUseCachedEtag($weak)) {
            return $this->cachedEtags[$weak];
        }

        return $this->cachedEtags[$weak] = $this->makeEtag($weak);
    }

    /**
     * Determine if evt. cached etag can be used
     *
     * @param  bool  $weak  [optional] Indication whether "weak" or "strong" etag
     *                      is desired
     *
     * @return bool
     */
    protected function canUseCachedEtag(bool $weak = true): bool
    {
        return isset($this->cachedEtags[$weak]) && $this->isClean();
    }

    /**
     * Returns "weak" flagged Etag representation of this component (intended for weak comparison)
     *
     * @param  bool  $force  [optional] When true then a new ETag instance is returned.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag
     */
    public function getWeakEtag(bool $force = false): ETag
    {
        return $this->getEtag(true, $force);
    }

    /**
     * Returns Etag representation of this component (intended for strong comparison)
     *
     * @param  bool  $force  [optional] When true then a new ETag instance is returned.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag
     */
    public function getStrongEtag(bool $force = false): ETag
    {
        return $this->getEtag(false, $force);
    }

    /**
     * Clears evt. cached Etag representation of thi component
     *
     * @return self
     */
    public function clearCachedEtag(): static
    {
        $this->cachedEtags = [];

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @return mixed Value that represents this Eloquent Model's data
     */
    public function etagValue(bool $weak = true): mixed
    {
        // RECOMMENDATION: Overwrite this method and adapt its return value
        // to fit your Eloquent model...

        $updatedAt = '';
        if (isset($this->attributes[$this->getUpdatedAtColumn()])) {
            $updatedAt = Carbon::make($this->attributes[$this->getUpdatedAtColumn()])->toRfc3339String(true);
        }

        return implode('_', [
            $this->getTable(),
            $this->getKey() ?? '',
            $updatedAt
        ]);
    }
}
