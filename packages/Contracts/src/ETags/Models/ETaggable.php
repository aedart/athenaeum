<?php

namespace Aedart\Contracts\ETags\Models;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\Generator;

/**
 * ETaggable
 *
 * Eloquent Models that inherit from this interface are able to generate
 * an Etag representation the model.
 *
 * @see \Aedart\Contracts\ETags\ETag
 * @see \Illuminate\Database\Eloquent\Model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Models
 */
interface ETaggable
{
    /**
     * Returns an ETag that represents this model
     *
     * @param  bool  $weak  [optional] When true, ETag is flagged as "weak",
     *                      indented to be used for "weak comparison" (E.g. If-None-Match Http header comparison).
     *                      When false, ETag is not flagged as "weak",
     *                      intended to be used for "strong comparison" (E.g. If-Match Http header comparison).
     * @param  string|null  $profile  [optional] Name of {@see Generator} profile to be used.
     *                                 If none given, then {@see defaultETagGeneratorProfile} will be used.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag for this model
     */
    public function makeEtag(bool $weak = true, string|null $profile = null): ETag;

    /**
     * Returns a "weak" ETag that represents this mode, intended for weak comparison
     *
     * @param  string|null  $profile  [optional] Name of {@see Generator} profile to be used.
     *                                 If none given, then {@see etagGeneratorProfile} will be used.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag for this model
     */
    public function weakEtag(string|null $profile = null): ETag;

    /**
     * Returns a ETag that represents this mode, intended for strong comparison
     *
     * @param  string|null  $profile  [optional] Name of {@see Generator} profile to be used.
     *                                 If none given, then {@see etagGeneratorProfile} will be used.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag for this model
     */
    public function strongEtag(string|null $profile = null): ETag;

    /**
     * Returns name of the default ETag Generator profile to use,
     * for this model
     *
     * @return string
     */
    public function etagGeneratorProfile(): string;

    /**
     * Returns a value to be used for when generating an ETag representation
     * of this model
     *
     * @param  bool  $weak  [optional]
     *
     * @return mixed
     */
    public function etagValue(bool $weak = true): mixed;
}