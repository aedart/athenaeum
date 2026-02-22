<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;
use Illuminate\Contracts\Pipeline\Pipeline as PipelineInterface;
use Illuminate\Pipeline\Pipeline;

/**
 * Concerns Driver Options
 *
 * @see Builder
 * @see Builder::withOption
 * @see Builder::withOptions
 * @see Builder::withoutOption
 * @see Builder::hasOption
 * @see Builder::getOption
 * @see Builder::getOptions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait DriverOptions
{
    /**
     * Driver specific options for the next request
     *
     * @var array
     */
    protected array $options = [];

    /**
     * @inheritdoc
     */
    public function withOption(string $name, mixed $value): static
    {
        return $this->withOptions([ $name => $value ]);
    }

    /**
     * @inheritdoc
     */
    public function withOptions(array $options = []): static
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withoutOption(string $name): static
    {
        unset($this->options[$name]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasOption(string $name): bool
    {
        return isset($this->options[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getOption(string $name): mixed
    {
        if ($this->hasOption($name)) {
            return $this->options[$name];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Prepares this builder, based on given driver specific options.
     *
     * Method MIGHT alter the resulting driver options, depending on
     * circumstance and context.
     *
     * @param array $options [optional] Driver specific options
     *
     * @return array Driver specific options
     */
    protected function prepareBuilderFromOptions(array $options = []): array
    {
        return $options;
    }

    /**
     * Processes the driver's options via given set of pipes
     *
     * Depending on the given pipes and options, both the
     * provided options, and this builder's properties
     * and state can be mutated by the pipes.
     *
     * @see makePipeline
     * @see \Illuminate\Contracts\Pipeline\Pipeline
     *
     * @param array<class-string> $pipes List of class paths
     * @param array $options [optional]
     *
     * @return array Processed Driver Options
     */
    protected function processDriverOptions(array $pipes, array $options = []): array
    {
        return $this
            ->makePipeline()
            ->send(new ProcessedOptions($this, $options))
            ->through($pipes)
            ->then(function (ProcessedOptions $prepared) {
                return $prepared->options();
            });
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
