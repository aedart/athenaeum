<?php

namespace Aedart\Database\Query;

use Aedart\Contracts\Database\Query\Exceptions\CriteriaException;
use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Database\Query\Exceptions\FilterException;
use Aedart\Database\Query\Exceptions\InvalidOperator;

/**
 * Field Filter
 *
 * Base abstraction for database query filter to be applied on a specific field.
 *
 * @see \Aedart\Contracts\Database\Query\FieldCriteria
 * @see \Aedart\Database\Query\Filter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Database\Query
 */
abstract class FieldFilter extends Filter implements FieldCriteria
{
    /**
     * Field this filter must be applied on
     *
     * @var string
     */
    protected string $field;

    /**
     * The operator to be used
     *
     * @var string
     */
    protected string $operator;

    /**
     * The field value to be matched against
     *
     * @var mixed
     */
    protected mixed $value = null;

    /**
     * The logical operator
     *
     * @var string
     */
    protected string $logicalOperator;

    /**
     * FieldFilter
     *
     * @param string|null $field [optional]
     * @param string|null $operator [optional]
     * @param mixed $value [optional]
     * @param string $logical [optional]
     *
     * @throws CriteriaException
     */
    public function __construct(
        string|null $field = null,
        string|null $operator = null,
        mixed $value = null,
        string $logical = FieldCriteria::AND
    ) {
        if (isset($field)) {
            $this->setField($field);
        }

        if (isset($operator)) {
            $this->setOperator($operator);
        }

        $this->setLogical($logical);

        if (isset($value)) {
            $this->setValue($value);
        }
    }

    /**
     * @inheritdoc
     */
    public static function make(
        string|null $field = null,
        string|null $operator = null,
        mixed $value = null,
        string $logical = FieldCriteria::AND
    ): static {
        return new static($field, $operator, $value, $logical);
    }

    /**
     * @inheritDoc
     */
    public function setField(string $field): static
    {
        $this->assertField($field);

        $this->field = $field;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @inheritDoc
     */
    public function field(): string
    {
        return $this->getField();
    }

    /**
     * @inheritDoc
     */
    public function setOperator(string $operator): static
    {
        $this->assertOperator($operator, $this->allowedOperators());

        $this->operator = $operator;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @inheritDoc
     */
    public function operator(): string
    {
        return $this->getOperator();
    }

    /**
     * @inheritDoc
     */
    public function setValue(mixed $value): static
    {
        $this->assertValue($value);

        $this->value = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function value(): mixed
    {
        return $this->getValue();
    }

    /**
     * @inheritDoc
     */
    public function setLogical(string $operator = self::AND): static
    {
        $this->assertOperator($operator, $this->allowedLogicalOperators());

        $this->logicalOperator = $operator;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLogical(): string
    {
        return $this->logicalOperator;
    }

    /**
     * @inheritDoc
     */
    public function logical(): string
    {
        return $this->getLogical();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns list of supported / allowed logical operators
     *
     * @return string[] If list contains a wildcard (*) as the first elem,
     *                  then it means that all operators are supported.
     */
    protected function allowedLogicalOperators(): array
    {
        return [
            FieldCriteria::AND,
            FieldCriteria::OR,
        ];
    }

    /**
     * Returns list of supported / allowed operators
     *
     * @return string[] If list contains a wildcard (*) as the first elem,
     *                  then it means that all operators are supported.
     */
    protected function allowedOperators(): array
    {
        return [ '*' ];
    }

    /**
     * Assert whether given operators is allowed or not
     *
     * @param string $operator
     * @param string[] $allowed [optional]
     *
     * @throws InvalidOperator
     */
    protected function assertOperator(string $operator, array $allowed = [ '*' ])
    {
        // Skip assert if all operators are allowed.
        if (!empty($allowed) && $allowed[0] === '*') {
            return;
        }

        if (!in_array($operator, $allowed)) {
            throw new InvalidOperator(sprintf('Operator %s is not supported. Allowed operators: %s', $operator, implode(', ', $allowed)));
        }
    }

    /**
     * Assert field name
     *
     * @param string $field
     *
     * @throws FilterException
     */
    protected function assertField(string $field)
    {
        if (empty($field)) {
            throw new FilterException('A field name was expected, but empty string was given');
        }
    }

    /**
     * Assert field value
     *
     * @param mixed $value
     *
     * @throws FilterException
     */
    protected function assertValue(mixed $value)
    {
        // N/A - by default no value assertion is done here.
        // Overwrite this method, if you wish to assert value,
        // before this filter is applied.
    }
}
