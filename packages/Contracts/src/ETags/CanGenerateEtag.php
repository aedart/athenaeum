<?php

namespace Aedart\Contracts\ETags;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;

/**
 * Can Generate Etag
 *
 * Able to generate Etag using predefined value.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags
 */
interface CanGenerateEtag
{
    /**
     * Generates a new ETag
     *
     * Method uses output from {@see etagValue()} to generate new ETag.
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
     * @throws ETagGeneratorException If unable to generate ETag
     */
    public function makeEtag(bool $weak = true, string|null $profile = null): ETag;

    /**
     * Returns a new "weak" ETag, intended for weak comparison
     *
     * Method uses output from {@see etagValue()} to generate new ETag.
     *
     * @param  string|null  $profile  [optional] Name of {@see Generator} profile to be used.
     *                                If none given, then {@see etagGeneratorProfile} will be used.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag
     */
    public function makeWeakEtag(string|null $profile = null): ETag;

    /**
     * Returns a new ETag, intended for strong comparison
     *
     * Method uses output from {@see etagValue()} to generate new ETag.
     *
     * @param  string|null  $profile  [optional] Name of {@see Generator} profile to be used.
     *                                If none given, then {@see etagGeneratorProfile} will be used.
     *
     * @return ETag
     *
     * @throws ETagGeneratorException If unable to generate ETag
     */
    public function makeStrongEtag(string|null $profile = null): ETag;

    /**
     * Returns name of the default ETag Generator profile to use,
     * for this component
     *
     * @return string
     */
    public function etagGeneratorProfile(): string;

    /**
     * Returns a value to be used for when generating an ETag
     *
     * @param  bool  $weak  [optional] Indication whether value is going to be
     *                      used for generating a "weak" flagged etag or not.
     *
     * @return mixed
     */
    public function etagValue(bool $weak = true): mixed;
}
