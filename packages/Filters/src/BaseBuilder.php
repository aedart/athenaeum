<?php

namespace Aedart\Filters;

use Aedart\Contracts\Filters\Builder;
use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Contracts\Filters\Exceptions\InvalidParameterException;
use Aedart\Contracts\Filters\Processor;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pipeline\Pipeline as PipelineInterface;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Validation\ValidationException;

/**
 * Base Builder
 *
 * @see \Aedart\Contracts\Filters\Builder
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters
 */
abstract class BaseBuilder implements Builder
{
    use ContainerTrait;

    /**
     * The current request
     *
     * @var Request
     */
    protected Request $request;

    /**
     * Builder
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public static function make($request): static
    {
        return new static($request);
    }

    /**
     * @inheritDoc
     */
    public function build(): BuiltFiltersMap
    {
        return $this->process(
            $this->prepareProcessors()
        );
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Prepare http query param processors
     *
     * @return Processor[]
     */
    protected function prepareProcessors(): array
    {
        $request = $this->request;
        $map = $this->processors();
        $output = [];

        foreach ($map as $param => $processor) {
            // Skip the processor, if no matching parameter was requested and
            // the processor is not set to be forced applied.
            if (!$request->has($param) && !$processor->mustBeApplied()) {
                continue;
            }

            $output[] = $this->prepare($param, $processor);
        }

        return $output;
    }

    /**
     * Prepares http query param processor
     *
     * @param string $parameter
     * @param Processor $processor
     *
     * @return Processor
     */
    protected function prepare(string $parameter, Processor $processor): Processor
    {
        return $processor
            ->fromRequest($this->request)
            ->usingParameter($parameter);
    }

    /**
     * Processes the http query parameter via all given processors
     *
     * @param Processor[] $processors
     *
     * @return BuiltFilters
     *
     * @throws ValidationException
     */
    protected function process(array $processors): BuiltFilters
    {
        try {
            // Process the http query parameter through all the given
            // processors. The parameter is already be assigned
            // to each of the processors, when reaching this point...
            return $this
                ->makePipeline()
                ->send($this->makeBuiltFilters())
                ->through($processors)
                ->via('process')
                ->then(function (BuiltFilters $built) {
                    return $built;
                });
        } catch (InvalidParameterException $e) {
            // Use the parameter that is specified in the exception
            $param = $e->parameter();

            throw ValidationException::withMessages([
                $param => $e->getMessage()
            ]);
        }
    }

    /**
     * Creates a new built filters instance
     *
     * @return BuiltFiltersMap
     *
     * @throws BindingResolutionException
     */
    protected function makeBuiltFilters(): BuiltFiltersMap
    {
        return $this
            ->getContainer()
            ->make(BuiltFiltersMap::class);
    }

    /**
     * Creates a new Pipeline instance
     *
     * @return PipelineInterface
     */
    protected function makePipeline(): PipelineInterface
    {
        return new Pipeline($this->getContainer());
    }
}
