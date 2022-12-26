<?php

namespace Aedart\Contracts\ETags\Preconditions;

use Ramsey\Collection\CollectionInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Http "Range" Validator
 *
 * Specialised validator intended to be a subcomponent of Http Request
 * preconditions, when determining if requested "Range" is applicable or not.
 *
 * @see https://httpwg.org/specs/rfc9110.html#field.range
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\ETags\Preconditions
 */
interface RangeValidator extends
    HasRequest,
    HasActions
{
    /**
     * Validates requested "Range" header field, for given resource
     *
     * Method is able to use abort {@see Actions} if requested range is invalid
     * or not satisfiable.
     *
     * @param  ResourceContext  $resource
     *
     * @return CollectionInterface Validated unit ranges. Empty collection, if none was requested e.g. empty "Range" header.
     *                             Or if a single range is requested that matches resource's total size.
     *
     *
     * @throws HttpExceptionInterface
     */
    public function validate(ResourceContext $resource): CollectionInterface;

    /**
     * Returns the allowed or supported range unit
     *
     * @see https://httpwg.org/specs/rfc9110.html#range.units
     *
     * @return string E.g. bytes
     */
    public function allowedRangeUnit(): string;

    /**
     * Returns the maximum allowed or supported range sets
     *
     * @see https://httpwg.org/specs/rfc9110.html#range.specifiers
     *
     * @return int
     */
    public function maximumRangeSets(): int;
}