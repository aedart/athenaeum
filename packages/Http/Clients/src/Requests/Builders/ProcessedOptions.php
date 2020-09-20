<?php

namespace Aedart\Http\Clients\Requests\Builders;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Processed Driver Options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders
 */
class ProcessedOptions
{
    /**
     * The Http Request Builder
     *
     * @var Builder
     */
    protected Builder $builder;

    /**
     * The processed driver options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * ProcessedOptions constructor.
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
     * Set the processed driver options
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
     * Returns the processed driver options
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
     * Returns the Http Client used by the {@see Builder}
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->getBuilder()->client();
    }

    /**
     * Alias for {@see getBuilder}
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return $this->getBuilder();
    }

    /**
     * Alias for {@see getClient}
     *
     * @return Client
     */
    public function client(): Client
    {
        return $this->getClient();
    }
}
