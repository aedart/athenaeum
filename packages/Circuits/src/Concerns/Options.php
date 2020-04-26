<?php


namespace Aedart\Circuits\Concerns;

/**
 * Concerns Options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Concerns
 */
trait Options
{
    /**
     * Options
     *
     * @var array|null
     */
    protected ?array $options = null;

    /**
     * Set an option's value
     *
     * @param string $key
     * @param mixed $value
     *
     * @return self
     */
    public function withOption(string $key, $value)
    {
        return $this->withOptions([ $key => $value ]);
    }

    /**
     * Merge options with existing options
     *
     * @param array $options [optional]
     *
     * @return self
     */
    public function withOptions(array $options = [])
    {
        return $this->setOptions(
            array_merge($this->getOptions(), $options)
        );
    }

    /**
     * Set options
     *
     * @param array $options Options
     *
     * @return self
     */
    public function setOptions(array $options = [])
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return array options or null if none options has been set
     */
    public function getOptions(): array
    {
        if (!$this->hasOptions()) {
            $this->setOptions($this->getDefaultOptions());
        }
        return $this->options;
    }

    /**
     * Determine if option exist
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasOption(string $key): bool
    {
        return isset($this->options[$key]);
    }

    /**
     * Get option's value or default
     *
     * @param string $key
     * @param mixed $default [optional]
     *
     * @return mixed
     */
    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * Determine if options have been set
     *
     * @return bool
     */
    public function hasOptions(): bool
    {
        return isset($this->options);
    }

    /**
     * Get a default options
     *
     * @return array
     */
    public function getDefaultOptions(): ?array
    {
        return [];
    }
}
