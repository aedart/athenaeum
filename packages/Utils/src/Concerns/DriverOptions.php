<?php

namespace Aedart\Utils\Concerns;

use Aedart\Utils\Arr;

/**
 * Concerns Driver Options
 *
 * @see \Aedart\Contracts\Utils\HasDriverOptions
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Concerns
 */
trait DriverOptions
{
    /**
     * This driver's options
     *
     * @var array<string, mixed>
     */
    protected array $options = [];

    /**
     * Set value for option with given key
     *
     * @param  string|int  $key
     * @param  mixed  $value
     *
     * @return self
     */
    public function set(string|int $key, mixed $value): static
    {
        Arr::set($this->options, $key, $value);

        return $this;
    }

    /**
     * Get option value that matches key
     *
     * @param string|int $key
     * @param mixed $default [optional] Default value to return when key does not exist
     *
     * @return mixed
     */
    public function get(string|int $key, mixed $default = null): mixed
    {
        return Arr::get($this->options, $key, $default);
    }

    /**
     * Determine if value exists for option that matches key
     *
     * @param  string|int  $key
     *
     * @return bool
     */
    public function has(string|int $key): bool
    {
        return Arr::has($this->options, $key);
    }

    /**
     * Set driver's options
     *
     * @param  array  $options
     *
     * @return self
     */
    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get driver's options
     *
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
