<?php

namespace Aedart\Http\Clients\Requests\Query\Grammars;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Contracts\Http\Clients\Requests\Query\Identifiers;
use Aedart\Http\Clients\Exceptions\UnableToBuildHttpQuery;
use Aedart\Utils\Arr;
use function GuzzleHttp\Psr7\build_query;

/**
 * Base Http Query Grammar
 *
 * Abstraction for Http Query Grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query\Grammars
 */
abstract class BaseGrammar implements
    Grammar,
    Identifiers
{
    /**
     * Grammar options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * The Http Query builder instance
     *
     * @var Builder|null
     */
    protected ?Builder $query = null;

    /**
     * Select key
     *
     * @var string
     */
    protected string $selectKey = 'select';

    /**
     * Binding key prefix
     *
     * @var string
     */
    protected string $bindingKeyPrefix = ':';

    /**
     * BaseGrammar constructor.
     *
     * @param array $options [optional]
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function compile(Builder $builder): string
    {
        $this->query = $builder;

        return $this->compileHttpQueryParts($builder->toArray());
    }

    /**
     * Returns the Http Query builder, if available
     *
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->query;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Compiles the various Http Query Builder's parts
     *
     * @param array $parts [optional]
     *
     * @return string Http Query string or empty if no parts given
     *
     * @throws HttpQueryBuilderException
     */
    protected function compileHttpQueryParts(array $parts = []): string
    {
        if (empty($parts)) {
            return '';
        }

        return '?' . implode('&', [
            $this->compileSelects($parts[self::SELECTS]),
            $this->compileWheres($parts[self::WHERES])
        ]);
    }

    /**
     * Compiles the various selects
     *
     * @param array $selects [optional]
     *
     * @return string Compiled selects or empty string if none given
     */
    protected function compileSelects(array $selects = []): string
    {
        if (empty($selects)) {
            return '';
        }

        $output = [];
        foreach ($selects as $select) {
            $output[] = $this->compileSelect($select);
        }

        return $this->selectKey . '=' . implode(',', $output);
    }

    /**
     * Compiles a regular or raw select
     *
     * @see compileRegularSelect
     * @see compileRawSelect
     *
     * @param array $select
     *
     * @return string
     */
    protected function compileSelect(array $select): string
    {
        if ($select[self::TYPE] === self::SELECT_TYPE_RAW) {
            return $this->compileRawSelect($select);
        }

        return $this->compileRegularSelect($select);
    }

    /**
     * Compiles a regular select
     *
     * @param array $select
     *
     * @return string
     */
    protected function compileRegularSelect(array $select): string
    {
        $output = [];

        $fields = $select[self::FIELDS];
        foreach ($fields as $field => $from) {
            // When an expression is given
            if (is_numeric($field)) {
                $output[] = trim($from);
                continue;
            }

            // When "from resource" isn't provided
            if (empty($from)) {
                $output[] = trim($field);
                continue;
            }

            // When "from resource" and field is given
            $output[] = $this->compileFieldFromResource(trim($field), trim($from));
        }

        return implode(',', $output);
    }

    /**
     * Compiles a "field from a resource"
     *
     * @param string $field
     * @param string $resource
     *
     * @return string
     */
    protected function compileFieldFromResource(string $field, string $resource): string
    {
        return "{$resource}.{$field}";
    }

    /**
     * Compiles a raw select (expression)
     *
     * @param array $select
     *
     * @return string
     */
    protected function compileRawSelect(array $select): string
    {
        return $this->compileExpression(
            $this->compileRegularSelect($select),
            $select[self::BINDINGS]
        );
    }

    /**
     * Compiles the various where conditions or filters
     *
     * @param array $wheres
     *
     * @return string
     *
     * @throws HttpQueryBuilderException
     */
    protected function compileWheres(array $wheres = []): string
    {
        if (empty($wheres)) {
            return '';
        }

        $output = [];
        foreach ($wheres as $where) {
            $output[] = $this->compileWhere($where);
        }

        return implode('&', $output);
    }

    /**
     * Compiles a regular or raw where condition or filter
     *
     * @see compileRegularWhere
     * @see compileRawWhere
     *
     * @param array $where
     *
     * @return string
     *
     * @throws HttpQueryBuilderException
     */
    protected function compileWhere(array $where): string
    {
        if ($where[self::TYPE] === self::SELECT_TYPE_RAW) {
            return $this->compileRawWhere($where);
        }

        return $this->compileRegularWhere($where);
    }

    /**
     * Compiles a regular where condition or filter
     *
     * @param array $where
     *
     * @return string
     *
     * @throws HttpQueryBuilderException
     */
    protected function compileRegularWhere(array $where): string
    {
        $field = $where[self::FIELD];
        $operator = $this->resolveOperator($where[self::OPERATOR], $field);
        $value = $where[self::VALUE];

        // Compile as an array, when value matches an associative array and
        // equals operator is used.
        if (is_array($value) && Arr::isAssoc($value) && $operator === '=') {
            return $this->compileArray([ $field => $value ]);
        }

        // When no equals operator has been provided, then we append the
        // operator.
        if (is_array($value) && Arr::isAssoc($value)) {
            return $this->compileArray([ $field => [ $operator => $value ] ]);
        }

        // Otherwise when just a list of values has been given, then we just
        // convert it into a comma separated list.
        if (is_array($value)) {
            $value = implode(',', $value);
        }

        // Omit operator if it matches equals sign
        if ($operator === '=') {
            return "{$field}={$value}";
        }

        // Lastly, assemble field, operator and value
        return "{$field}[{$operator}]={$value}";
    }

    /**
     * Compiles a "raw where" condition (expression)
     *
     * @param array $where
     *
     * @return string
     */
    protected function compileRawWhere(array $where): string
    {
        $expression = $where[self::FIELD];

        if (is_string($expression)) {
            return $this->compileExpression($expression, $where[self::BINDINGS]);
        }

        if (is_array($expression)) {
            return $this->compileArray($expression);
        }

        throw new UnableToBuildHttpQuery(sprintf(
            'Expected raw where condition to be either string or array. %s given',
            gettype($expression)
        ));
    }

    /**
     * Compiles given expression
     *
     * Method will inject bindings into given expression, if any bindings
     * are given.
     *
     * @param string $expression
     * @param array $bindings [optional]
     *
     * @return string
     */
    protected function compileExpression(string $expression, array $bindings = []): string
    {
        if (empty($bindings)) {
            return $expression;
        }

        $keys = $this->prepareBindingKeys(array_keys($bindings));
        $values = array_values($bindings);

        return str_replace($keys, $values, $expression);
    }

    /**
     * Prepares the binding keys
     *
     * @param string[] $keys
     *
     * @return string[]
     */
    protected function prepareBindingKeys(array $keys = []): array
    {
        return array_map(fn ($key) => $this->bindingKeyPrefix . $key, $keys);
    }

    /**
     * Resolves the given operator
     *
     * @param mixed $operator
     * @param string $field
     *
     * @return string
     *
     * @throws HttpQueryBuilderException
     */
    protected function resolveOperator($operator, string $field): string
    {
        if (!is_string($operator)) {
            throw new UnableToBuildHttpQuery(sprintf('Expected string operator for %s, %s given', $field, gettype($operator)));
        }

        return trim($operator);
    }

    /**
     * Compiles array parameters into a string
     *
     * @param array $params
     *
     * @return string
     */
    protected function compileArray(array $params): string
    {
        // Use Guzzle's build-query method, but avoid url
        // encoding it. Url encoding should be handled at
        // a later point...
        return build_query($params, false);
    }
}
