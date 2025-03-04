<?php

namespace Aedart\Support\Properties\Integers;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Row Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Integers\RowAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Integers
 */
trait RowTrait
{
    /**
     * A row identifier
     *
     * @var int|null
     */
    protected int|null $row = null;

    /**
     * Set row
     *
     * @param int|null $identifier A row identifier
     *
     * @return self
     */
    public function setRow(int|null $identifier): static
    {
        $this->row = $identifier;

        return $this;
    }

    /**
     * Get row
     *
     * If no row value set, method
     * sets and returns a default row.
     *
     * @see getDefaultRow()
     *
     * @return int|null row or null if no row has been set
     */
    public function getRow(): int|null
    {
        if (!$this->hasRow()) {
            $this->setRow($this->getDefaultRow());
        }
        return $this->row;
    }

    /**
     * Check if row has been set
     *
     * @return bool True if row has been set, false if not
     */
    public function hasRow(): bool
    {
        return isset($this->row);
    }

    /**
     * Get a default row value, if any is available
     *
     * @return int|null Default row value or null if no default value is available
     */
    public function getDefaultRow(): int|null
    {
        return null;
    }
}
