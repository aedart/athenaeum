<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Column Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ColumnAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ColumnTrait
{
    /**
     * Name of column
     *
     * @var string|null
     */
    protected $column = null;

    /**
     * Set column
     *
     * @param string|null $name Name of column
     *
     * @return self
     */
    public function setColumn(?string $name)
    {
        $this->column = $name;

        return $this;
    }

    /**
     * Get column
     *
     * If no "column" value set, method
     * sets and returns a default "column".
     *
     * @see getDefaultColumn()
     *
     * @return string|null column or null if no column has been set
     */
    public function getColumn() : ?string
    {
        if ( ! $this->hasColumn()) {
            $this->setColumn($this->getDefaultColumn());
        }
        return $this->column;
    }

    /**
     * Check if "column" has been set
     *
     * @return bool True if "column" has been set, false if not
     */
    public function hasColumn() : bool
    {
        return isset($this->column);
    }

    /**
     * Get a default "column" value, if any is available
     *
     * @return string|null Default "column" value or null if no default value is available
     */
    public function getDefaultColumn() : ?string
    {
        return null;
    }
}
