<?php

namespace Aedart\ETags\Preconditions;

use Aedart\Contracts\ETags\Preconditions\Actions as PreconditionActions;
use Aedart\Contracts\ETags\Preconditions\Evaluator as PreconditionsEvaluator;
use Aedart\Contracts\ETags\Preconditions\Precondition;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Actions\DefaultActions;
use Aedart\ETags\Preconditions\Additional\Range;
use Aedart\ETags\Preconditions\Rfc9110\IfMatch;
use Aedart\ETags\Preconditions\Rfc9110\IfModifiedSince;
use Aedart\ETags\Preconditions\Rfc9110\IfNoneMatch;
use Aedart\ETags\Preconditions\Rfc9110\IfRange;
use Aedart\ETags\Preconditions\Rfc9110\IfUnmodifiedSince;
use Illuminate\Http\Request;
use LogicException;

/**
 * Request Preconditions Evaluator
 *
 * @see \Aedart\Contracts\ETags\Preconditions\Evaluator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions
 */
class Evaluator implements PreconditionsEvaluator
{
    use Concerns\CurrentRequest;
    use Concerns\Preconditions;
    use Concerns\Actions;

    /**
     * Creates a new request preconditions evaluator instance
     *
     * @param  Request  $request
     * @param  string[]|Precondition[]  $preconditions  [optional] Defaults to predefined preconditions when empty.
     * @param  PreconditionActions|null  $actions  [optional] Defaults to predefined actions when none given.
     */
    public function __construct(Request $request, array $preconditions = [], PreconditionActions|null $actions = null) {
        $preconditions = !empty($preconditions)
            ? $preconditions
            : $this->getDefaultPreconditions();

        $actions = $actions ?? $this->getDefaultActions();

        $this
            ->setRequest($request)
            ->setPreconditions($preconditions)
            ->setActions($actions);
    }

    /**
     * Returns a new request preconditions evaluator instance
     *
     * @param  Request $request
     * @param  string[]|Precondition[]  $preconditions  [optional]
     * @param  PreconditionActions|null  $actions  [optional]
     *
     * @return static
     */
    public static function make($request, array $preconditions = [], PreconditionActions|null $actions = null): static
    {
        return new static($request, $preconditions, $actions);
    }

    /**
     * @inheritdoc
     */
    public function evaluate(ResourceContext $resource): ResourceContext
    {
        // [...] a server MUST ignore the conditional request header fields [...] when received with a
        // request method that does not involve the selection or modification of a selected representation,
        // such as CONNECT, OPTIONS, or TRACE [...]
        // @see https://httpwg.org/specs/rfc9110.html#when.to.evaluate
        if (in_array($this->getMethod(), ['CONNECT', 'OPTIONS', 'TRACE'])) {
            return $resource;
        }

        // Obtain preconditions to be evaluated or skip if none are set.
        $preconditions = $this->getPreconditions();
        if (empty($preconditions)) {
            return $resource;
        }

        $index = 0;
        $count = count($preconditions);
        while($index < $count) {

            // Prepare teh next precondition, Skip to next, if it's not applicable.
            $precondition = $this->preparePrecondition($preconditions[$index]);
            if (!$precondition->isApplicable($resource)) {
                $index++;
                continue;
            }

            // When precondition is applicable, then it must be processed. The result can either be a changed
            // state of given resource, or a class path to another precondition that must be evaluated.
            $result = $precondition->process($resource);
            if (is_string($result)) {
                $index = $this->verifyRequestedPrecondition(
                    requestedIndex: $this->findIndexOfPreconditionOrFail($result, $preconditions),
                    currentIndex: $index,
                    preconditions: $preconditions
                );
                continue;
            }

            // This means that the precondition has passed that the resource's state was
            // changed or set. No further preconditions must be evaluated and request must proceed.
            return $result;
        }

        // When this point is reached, all preconditions have been evaluated and none were applicable.
        // This means that the request should proceed as it normally would.
        return $resource;
    }

    /**
     * Returns default precondition actions
     *
     * @return PreconditionActions
     */
    public function getDefaultActions(): PreconditionActions
    {
        return new DefaultActions();
    }

    /**
     * Returns default preconditions
     *
     * @return string[]|Precondition[]
     */
    public function getDefaultPreconditions(): array
    {
        $rfc9110 = $this->getRfc9110Preconditions();
        $extensions = $this->getAdditionalPreconditions();

        return array_merge(
            $rfc9110,
            $extensions
        );
    }

    /**
     * Instruct this evaluator to ONLY evaluate RFC9110 defined preconditions
     *
     * @return self
     */
    public function useRfc9110Preconditions(): static
    {
        return $this->setPreconditions(
            $this->getRfc9110Preconditions()
        );
    }

    /**
     * Returns list of RFC9110 defined request preconditions
     *
     * @return string[]|Precondition[]
     */
    public function getRfc9110Preconditions(): array
    {
        // List of request preconditions ordered according to the
        // RFC9110 defined evaluation precedence.
        // @see https://httpwg.org/specs/rfc9110.html#precedence

        return [
            // 1. When recipient is the origin server and If-Match is present, [...]:
            IfMatch::class,

            // 2. When recipient is the origin server, If-Match is not present, and If-Unmodified-Since is present, [...]:
            IfUnmodifiedSince::class,

            // 3. When If-None-Match is present, [...]:
            IfNoneMatch::class,

            // 4. When the method is GET or HEAD, If-None-Match is not present, and If-Modified-Since is present, [...]:
            IfModifiedSince::class,

            // 5. When the method is GET and both Range and If-Range are present, [...]:
            IfRange::class

            // 6. Otherwise:
            //      [...] perform the requested method and respond according to its success or failure [...]
        ];
    }

    /**
     * Returns list of additional request preconditions, which are
     * NOT defined by RFC9110
     *
     * @return string[]|Precondition[]
     */
    public function getAdditionalPreconditions(): array
    {
        return [
            // x. When "Range" is requested, but without "If-Range" header, and "Range" is supported:
            Range::class
        ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Prepares the precondition for evaluation
     *
     * @param  string|Precondition  $precondition Class path or {@see Precondition} instance
     *
     * @return Precondition
     */
    protected function preparePrecondition(string|Precondition $precondition): Precondition
    {
        if (is_string($precondition)) {
            $precondition = new $precondition();
        }

        return $precondition
            ->setRequest($this->request())
            ->setActions($this->actions());
    }

    /**
     * Verifies requested precondition
     *
     * @param  int  $requestedIndex
     * @param  int  $currentIndex
     * @param  string[]|Precondition[]  $preconditions
     *
     * @return int
     */
    protected function verifyRequestedPrecondition(int $requestedIndex, int $currentIndex, array $preconditions): int
    {
        // When requested precondition is ranked after the current, then we can proceed.
        if ($requestedIndex > $currentIndex) {
            return $requestedIndex;
        }

        // When requested precondition is ranked before the current (or is the current) precondition,
        // then it might already be evaluated. To avoid re-evaluation or possible infinite loop,
        // the evaluation process must be stopped.
        $currentPrecondition = $preconditions[$currentIndex];
        $requestedPrecondition = $preconditions[$requestedIndex];

        throw new LogicException(sprintf(
            'Unable to evaluate %s precondition. It has either already been evaluated, or its ranked before %s precondition',
            $requestedPrecondition::class,
            $currentPrecondition::class
        ));
    }

    /**
     * Returns index of target precondition in given list of preconditions.
     *
     * Method fails if unable to find target's index
     *
     * @param  string  $target Class path
     * @param  string[]|Precondition[]  $preconditions
     *
     * @return int
     *
     * @throws LogicException
     */
    protected function findIndexOfPreconditionOrFail(string $target, array $preconditions): int
    {
        $preconditions = array_values($preconditions);

        foreach ($preconditions as $index => $precondition) {
            $class = is_object($precondition)
                ? $precondition::class
                : $precondition;

            if ($class === $target) {
                return $index;
            }
        }

        throw new LogicException(sprintf('Unable to find %s precondition', $target));
    }
}