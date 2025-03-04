<?php

namespace Aedart\Contracts\Database\Query;

use Aedart\Contracts\Database\Query\Exceptions\CriteriaException;
use Aedart\Contracts\Database\Query\Exceptions\InvalidOperatorException;

/**
 * Field Criteria (Query filter)
 *
 * A criteria that can be applied on a single field (table column).
 * Unlike a regular {@see Criteria}, a field criteria allows specifying
 * the operator, value and how the criteria should be applied, e.g. via "AND" / "OR"
 * logical operator.
 *
 * The final query filter that is built, will resemble the following: `"[logical operator] where <expression>"`,
 * e.g. `"or where name LIKE '%John%'"`
 *
 * @see Criteria
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Database\Query
 */
interface FieldCriteria extends Criteria
{
    /**
     * Logical 'and' operator
     */
    public const string AND = 'and';

    /**
     * Logical 'or' operator
     */
    public const string OR = 'or';

    /**
     * Creates a new field criteria instance
     *
     * @param string|null $field [optional]
     * @param string $operator [optional]
     * @param mixed $value [optional]
     * @param string $logical [optional]
     *
     * @return static
     *
     * @throws CriteriaException
     */
    public static function make(
        string|null $field = null,
        string $operator = '=',
        mixed $value = null,
        string $logical = self::AND
    ): static;

    /**
     * Set the field (column) criteria must be applied on
     *
     * @param string $field
     *
     * @return self
     *
     * @throws CriteriaException
     */
    public function setField(string $field): static;

    /**
     * Get the field (column) criteria must be applied on
     *
     * @return string
     */
    public function getField(): string;

    /**
     * Alias for {@see getField()}
     *
     * @return string
     */
    public function field(): string;

    /**
     * Set the operator to be used
     *
     * @param string $operator
     *
     * @return self
     *
     * @throws InvalidOperatorException
     */
    public function setOperator(string $operator): static;

    /**
     * Get the operator to be used
     *
     * @return string
     */
    public function getOperator(): string;

    /**
     * Alias for {@see getOperator()}
     *
     * @return string
     */
    public function operator(): string;

    /**
     * Set the field value to be matched against
     *
     * @param mixed $value
     *
     * @return self
     *
     * @throws CriteriaException
     */
    public function setValue(mixed $value): static;

    /**
     * Get the field value to be matched against
     *
     * @return mixed
     */
    public function getValue(): mixed;

    /**
     * Alias for {@see getValue()}
     *
     * @return mixed
     */
    public function value(): mixed;

    /**
     * Set the logical operator that determines how criteria
     * must be added in relation to other criteria
     *
     * @param string $operator AND, OR
     *
     * @return self
     *
     * @throws InvalidOperatorException
     */
    public function setLogical(string $operator = self::AND): static;

    /**
     * Get the logical operator that determines how criteria
     * must be added in relation to other criteria
     *
     * @return string
     */
    public function getLogical(): string;

    /**
     * Alias for {@see getLogical()}
     *
     * @return string
     */
    public function logical(): string;
}
