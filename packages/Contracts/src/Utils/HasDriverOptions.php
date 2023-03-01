<?php

namespace Aedart\Contracts\Utils;

/**
 * Has Driver Options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils
 */
interface HasDriverOptions
{
    /**
     * Set value for option with given key
     *
     * @param  string|int  $key
     * @param  mixed  $value
     *
     * @return self
     */
    public function set(string|int $key, mixed $value): static;

    /**
     * Get option value that matches key
     *
     * @param string|int $key
     * @param mixed $default [optional] Default value to return when key does not exist
     *
     * @return mixed
     */
    public function get(string|int $key, mixed $default = null): mixed;

    /**
     * Determine if value exists for option that matches key
     *
     * @param  string|int  $key
     *
     * @return bool
     */
    public function has(string|int $key): bool;

    /**
     * Set driver's options
     *
     * @param  array  $options
     *
     * @return self
     */
    public function setOptions(array $options): static;

    /**
     * Get driver's options
     *
     * @return array<string, mixed>
     */
    public function getOptions(): array;
}
