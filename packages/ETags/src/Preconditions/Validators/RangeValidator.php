<?php

namespace Aedart\ETags\Preconditions\Validators;

use Aedart\Contracts\ETags\Preconditions\RangeValidator as RangeValidatorInterface;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Concerns;
use Aedart\ETags\Preconditions\Validators\Exceptions\RangeNotSatisfiable;
use Aedart\ETags\Preconditions\Validators\Exceptions\RangeUnitNotSupported;
use Ramsey\Collection\CollectionInterface;
use Ramsey\Http\Range\Exception\InvalidRangeSetException;
use Ramsey\Http\Range\Exception\InvalidRangeUnitException;
use Ramsey\Http\Range\Exception\NoRangeException;
use Ramsey\Http\Range\Exception\NotSatisfiableException;
use Ramsey\Http\Range\Exception\ParseException;
use Ramsey\Http\Range\Unit\BytesRangesCollection;
use Ramsey\Http\Range\Unit\UnitInterface;
use Ramsey\Http\Range\Unit\UnitRangeInterface;
use Ramsey\Http\Range\UnitFactory;
use Ramsey\Http\Range\UnitFactoryInterface;

/**
 * Http "Range" Validator
 *
 * @see \Aedart\Contracts\ETags\Preconditions\RangeValidator
 * @see https://httpwg.org/specs/rfc9110.html#field.range
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Validators
 */
class RangeValidator implements RangeValidatorInterface
{
    use Concerns\CurrentRequest;
    use Concerns\Actions;

    /**
     * Creates a new range validator instance
     *
     * @see https://httpwg.org/specs/rfc9110.html#range.units
     * @see https://httpwg.org/specs/rfc9110.html#range.specifiers
     *
     * @param  string  $rangeUnit  [optional] Allowed or supported range unit, e.g. bytes
     * @param  int  $maxRangeSets  [optional] Maximum allowed range sets
     */
    public function __construct(
        protected string $rangeUnit = 'bytes',
        protected int $maxRangeSets = 5
    ) {
    }

    /**
     * @inheritdoc
     */
    public function validate(ResourceContext $resource): CollectionInterface
    {
        try {
            // Extract the "unit(s)" from the "Range" header and verify the range unit.
            $unit = $this->verifyRequestedRangeUnit(
                $this->extractUnitFromRequest($this->getRequest(), $resource->size())
            );

            // When no ranges requested, or just a single range unit is requested that has the same size
            // as the total size of the requested resource, then it makes no sense to process it as a
            // "206 Partial Content". The application should just proceed to regular content processing.
            $collection = $unit->getRanges();
            if ($collection->isEmpty() || ($collection->count() === 1 && $collection->first()->getLength() === $unit->getTotalSize())) {
                return $this->makeCollection();
            }

            // Otherwise, we must make sure that amount of requested ranges does not exceed the
            // maximum allowed ranges.
            $this->verifyAmountOfRanges($this->maximumRangeSets(), $unit, $collection);

            // Lastly, each range must be verified...
            return $this->verifyRanges($unit, $collection);
        } catch (NoRangeException $e) {
            // Edge case: no "Range" header available in request. Or [...] An origin server MUST
            // ignore a Range header field that contains a range unit it does not understand [...]
            // Regardless, we just mark range as not applicable.
            return $this->makeCollection();
        } catch (InvalidRangeUnitException|InvalidRangeSetException|ParseException|RangeUnitNotSupported $e) {
            // [...] A server that supports range requests MAY ignore or reject a Range header
            // field that contains an invalid ranges-specifier [...]
            $this->actions()->abortBadRequest($resource, $e->getMessage());
        } catch (NotSatisfiableException $e) {
            // [...] either the range-unit is not supported for that target resource or the ranges-specifier
            // is unsatisfiable with respect to the selected representation, the server SHOULD send a
            // 416 (Range Not Satisfiable) response. [...]
            $this->actions()->abortRangeNotSatisfiable($resource, $e->getRange(), $e->getTotalSize(), $this->allowedRangeUnit(), $e->getMessage());
        }
    }

    /**
     * @inheritdoc
     */
    public function allowedRangeUnit(): string
    {
        return $this->rangeUnit;
    }

    /**
     * @inheritdoc
     */
    public function maximumRangeSets(): int
    {
        return $this->maxRangeSets;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Verifies that ranges do not overlap or exceed resource's total size
     *
     * @param  UnitInterface  $unit
     * @param  CollectionInterface<UnitRangeInterface>|null  $collection  [optional]
     *
     * @return CollectionInterface<UnitRangeInterface>
     *
     * @throws RangeNotSatisfiable
     */
    protected function verifyRanges(UnitInterface $unit, CollectionInterface|null $collection = null): CollectionInterface
    {
        /** @var CollectionInterface<UnitRangeInterface> $collection */
        $collection = $collection ?? $unit->getRanges();

        // Total size of the payload
        $totalSize = $unit->getTotalSize();

        // Total amount of bytes requested
        $totalRequested = 0;

        // Previous range
        $previous = null;

        foreach ($collection as $range) {
            /** @var UnitRangeInterface $range */

            // Abort if range's start overlaps with previous range's end...
            if (isset($previous) && $range->getStart() <= $previous->getEnd()) {
                throw new RangeNotSatisfiable(
                    $unit->getRangeSet(),
                    $totalSize,
                    $unit->getRangeUnit(),
                    sprintf('Range %s overlaps with previous range %s.', $range->getRange(), $previous->getRange())
                );
            }

            $previous = $range;
            $totalRequested += $range->getLength();
        }

        // If total requested bytes is the same as the total file size
        // (or higher), then request should not be processed. It means that client
        // is asking for entire file content, yet divided into small chunks!?
        if ($totalRequested >= $totalSize) {
            throw new RangeNotSatisfiable(
                $unit->getRangeSet(),
                $totalSize,
                $unit->getRangeUnit(),
                sprintf('Requested ranges %s exceeds or matches total file size (%s bytes)', $unit->getRangeSet(), $totalSize)
            );
        }

        // Finally, return the valid ranges
        return $collection;
    }

    /**
     * Verify the amount of requested ranges
     *
     * @param  int $maxAllowed
     * @param  UnitInterface  $unit
     * @param  CollectionInterface<UnitRangeInterface>|null $collection  [optional]
     *
     * @return void
     *
     * @throws RangeNotSatisfiable
     */
    protected function verifyAmountOfRanges(int $maxAllowed, UnitInterface $unit, CollectionInterface|null $collection = null): void
    {
        $collection = $collection ?? $unit->getRanges();

        // Lastly, the amount of requested range units / range set must not exceed the allowed max value.
        if ($collection->count() > $maxAllowed) {
            $requested = $unit->getRangeSet();
            $totalSize = $unit->getTotalSize();
            $message = sprintf('Too many range sets requested. Unable to satisfy %s', $requested);

            throw new RangeNotSatisfiable($requested, $totalSize, $unit->getRangeUnit(), $message);
        }
    }

    /**
     * Verifies that requested range unit is accepted by the application
     *
     * @param  UnitInterface  $unit
     *
     * @return UnitInterface
     *
     * @throws RangeUnitNotSupported
     */
    protected function verifyRequestedRangeUnit(UnitInterface $unit): UnitInterface
    {
        $requested = $unit->getRangeUnit();
        $accepts = $this->allowedRangeUnit();

        if (strtolower($requested) !== strtolower($accepts)) {
            throw new RangeUnitNotSupported(sprintf('Only "%s" is accepted as Range unit. %s was provided', $accepts, $requested));
        }

        return $unit;
    }

    /**
     * Extracts unit(s) from the "Range" header field
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $totalSize
     *
     * @return UnitInterface
     *
     * @throws NoRangeException
     */
    protected function extractUnitFromRequest($request, int $totalSize): UnitInterface
    {
        $factory = $this->makeUnitFactory();

        $range = $request->header('Range', '');
        if (empty($range)) {
            throw new NoRangeException();
        }

        return $factory->getUnit($range, $totalSize);
    }

    /**
     * Returns a new Unit Factory instance
     *
     * @return UnitFactoryInterface
     */
    protected function makeUnitFactory(): UnitFactoryInterface
    {
        return new UnitFactory();
    }

    /**
     * Returns a collection instance
     *
     * @param  array  $data  [optional]
     *
     * @return CollectionInterface<UnitRangeInterface>
     */
    protected function makeCollection(array $data = []): CollectionInterface
    {
        return new BytesRangesCollection($data);
    }
}
