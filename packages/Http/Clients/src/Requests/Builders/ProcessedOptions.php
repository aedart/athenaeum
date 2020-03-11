<?php

namespace Aedart\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Prepared Driver Options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders
 */
class PreparedOptions
{
    /**
     * The Http Request Builder
     *
     * @var Builder
     */
    protected Builder $builder;

    /**
     * The prepared driver options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * PreparedOptions constructor.
     *
     * @param Builder $builder
     * @param array $options [optional]
     */
    public function __construct(Builder $builder, array $options = [])
    {
        $this
            ->setBuilder($builder)
            ->setOptions($options);
    }

    /**
     * Set the prepared driver options
     *
     * @param array $options [optional]
     *
     * @return self
     */
    public function setOptions(array $options = [])
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Returns the prepared driver options
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Alias for getPreparedOptions
     *
     * @see getOptions
     *
     * @return array
     */
    public function options(): array
    {
        return $this->getOptions();
    }

    /**
     * Set the Http Request Builder
     *
     * @param Builder $builder
     *
     * @return self
     */
    public function setBuilder(Builder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * Return the Http Request Builder
     *
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    /**
     * Alias for getBuilder
     *
     * @see getBuilder
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return $this->getBuilder();
    }
}
