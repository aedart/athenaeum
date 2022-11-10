<?php

namespace Aedart\ETags\Models\Concerns;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\ETags\Facades\Generator;
use Illuminate\Support\Facades\Config;

/**
 * Concerns Model ETags
 *
 * Offers default implementation for the {@see \Aedart\Contracts\ETags\Models\ETaggable} interface.
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Models\Concerns
 */
trait ModelETags
{
    /**
     * Returns an ETag that represents this model
     *
     * @param  bool  $weak  [optional] When true, ETag is flagged as "weak",
     *                      indented to be used for "weak comparison" (E.g. If-None-Match Http header comparison).
     *                      When false, ETag is not flagged as "weak",
     *                      intended to be used for "strong comparison" (E.g. If-Match Http header comparison).
     * @param  string|null  $profile  [optional] Name of {@see Generator} profile to be used.
     *                                 If none given, then {@see etagGeneratorProfile} will be used.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag for this model
     */
    public function makeEtag(bool $weak = true, string|null $profile = null): ETag
    {
        $profile = $profile ?? $this->etagGeneratorProfile();

        return Generator::profile($profile)->make(
            content: $this->etagValue($weak),
            weak: $weak
        );
    }

    /**
     * Returns a "weak" ETag that represents this model, intended for weak comparison
     *
     * @param  string|null  $profile  [optional] Name of {@see Generator} profile to be used.
     *                                 If none given, then {@see etagGeneratorProfile} will be used.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag for this model
     */
    public function weakEtag(?string $profile = null): ETag
    {
        return $this->makeEtag(true, $profile);
    }

    /**
     * Returns a ETag that represents this model, intended for strong comparison
     *
     * @param  string|null  $profile  [optional] Name of {@see Generator} profile to be used.
     *                                 If none given, then {@see etagGeneratorProfile} will be used.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag for this model
     */
    public function strongEtag(?string $profile = null): ETag
    {
        return $this->makeEtag(false, $profile);
    }

    /**
     * Returns name of the default ETag Generator profile to use,
     * for this model
     *
     * @return string
     */
    public function etagGeneratorProfile(): string
    {
        return Config::get('etags.default_generator', 'default');
    }

    /**
     * Returns a string representation of this model, to be used
     * for {@see Generator::make()}'s content, when making an ETag
     *
     * @param  bool  $weak  [optional]
     *
     * @return mixed
     */

    /**
     * Returns a value to be used for when generating an ETag representation
     * of this model
     *
     * @param  bool  $weak  [optional]
     *
     * @return mixed
     */
    public function etagValue(bool $weak = true): mixed
    {
        return match ($weak) {
            true => $this->weakEtagAttributes(),
            false => $this->strongETagAttributes(),
        };
    }

    /**
     * Returns values to be used for generating a "weak" ETag (weak comparison)
     *
     * @return string[]|int[]|float[] Values to be used for generating {@see ETag::raw} value
     */
    protected function weakEtagAttributes(): array
    {
        return [
            $this->getTable(),
            $this->getKey(),
            $this->attributes[$this->getUpdatedAtColumn()] ?? null
        ];
    }

    /**
     * Returns values to be used for generating an  ETag (strong comparison)
     *
     * @return string[]|int[]|float[] Values to be used for generating {@see ETag::raw} value
     */
    protected function strongETagAttributes(): array
    {
        return [ $this->getTable(), ...array_values(
            $this->attributesToArray()
        )];
    }
}