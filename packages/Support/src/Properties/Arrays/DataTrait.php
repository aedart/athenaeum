<?php

namespace Aedart\Support\Properties\Arrays;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Data Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Arrays\DataAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Arrays
 */
trait DataTrait
{
    /**
     * A list (array) containing a set of values
     *
     * @var array|null
     */
    protected array|null $data = null;

    /**
     * Set data
     *
     * @param array|null $values A list (array) containing a set of values
     *
     * @return self
     */
    public function setData(array|null $values): static
    {
        $this->data = $values;

        return $this;
    }

    /**
     * Get data
     *
     * If no data value set, method
     * sets and returns a default data.
     *
     * @see getDefaultData()
     *
     * @return array|null data or null if no data has been set
     */
    public function getData(): array|null
    {
        if (!$this->hasData()) {
            $this->setData($this->getDefaultData());
        }
        return $this->data;
    }

    /**
     * Check if data has been set
     *
     * @return bool True if data has been set, false if not
     */
    public function hasData(): bool
    {
        return isset($this->data);
    }

    /**
     * Get a default data value, if any is available
     *
     * @return array|null Default data value or null if no default value is available
     */
    public function getDefaultData(): array|null
    {
        return null;
    }
}
