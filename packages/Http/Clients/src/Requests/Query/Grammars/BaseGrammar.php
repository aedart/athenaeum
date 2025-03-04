<?php

namespace Aedart\Http\Clients\Requests\Query\Grammars;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Contracts\Http\Clients\Requests\Query\Identifiers;
use Aedart\Http\Clients\Exceptions\UnableToBuildHttpQuery;
use Aedart\Http\Clients\Requests\Query\Grammars\Dates\DateValue;
use DateTime;
use DateTimeInterface;
use Exception;
use Throwable;

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
    protected Builder|null $query = null;

    /**
     * The default parameter separator
     *
     * @var string
     */
    protected string $defaultParameterSeparator = '&';

    /**
     * Default "and where" separator
     *
     * @var string
     */
    protected string $defaultAndSeparator = '&';

    /**
     * Default "or where" separator
     *
     * @var string
     */
    protected string $defaultOrSeparator = '&|';

    /**
     * Select key, prefix for selects
     *
     * @var string
     */
    protected string $selectKey = 'select';

    /**
     * Include key, prefix for includes
     *
     * @var string
     */
    protected string $includeKey = 'include';

    /**
     * Limit key, prefix
     *
     * @var string
     */
    protected string $limitKey = 'limit';

    /**
     * Offset key, prefix
     *
     * @var string
     */
    protected string $offsetKey = 'offset';

    /**
     * Page number key, prefix
     *
     * @var string
     */
    protected string $pageNumberKey = 'page';

    /**
     * Page size, prefix
     *
     * @var string
     */
    protected string $pageSizeKey = 'show';

    /**
     * Sorting key, prefix for "order by" criteria
     *
     * @var string
     */
    protected string $orderByKey = 'sort';

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

        return $this->compileHttpQuery($builder->toArray());
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
    protected function compileHttpQuery(array $parts = []): string
    {
        if (empty($parts)) {
            return '';
        }

        $compiled = array_filter(
            $this->compileFragments($parts),
            fn ($element) => !empty($element)
        );

        return implode($this->resolveParameterSeparator(), $compiled);
    }

    /**
     * Compiles the individual fragments of the http query
     *
     * @param array $parts
     * @return string[] Compiled fragments of the http query
     *
     * @throws HttpQueryBuilderException
     */
    protected function compileFragments(array $parts): array
    {
        return [
            $this->compileSelects($parts[self::SELECTS]),
            $this->compileWheres($parts[self::WHERES]),
            $this->compileIncludes($parts[self::INCLUDES]),
            $this->compileLimit($parts[self::LIMIT]),
            $this->compileOffset($parts[self::OFFSET]),
            $this->compilePageNumber($parts[self::PAGE_NUMBER]),
            $this->compilePageSize($parts[self::PAGE_SIZE]),
            $this->compileOrderBy($parts[self::ORDER_BY]),
            $this->compileRawExpressions($parts[self::RAW]),
        ];
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
        $first = true;
        foreach ($wheres as $where) {
            // Remove conjunction from first condition...
            $where[self::CONJUNCTION] = $first ? '' : $where[self::CONJUNCTION];

            $output[] = $this->compileWhere($where);
            $first = false;
        }

        //return implode($this->resolveParameterSeparator(), $output);
        return implode('', $output);
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
        if ($where[self::TYPE] === self::WHERE_TYPE_RAW) {
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
        $value = $this->resolveValue($where[self::VALUE]);
        $conjunction = $this->resolveConjunction($where[self::CONJUNCTION]);

        // If provided value isn't an array, and the operator isn't the default
        // equals operator, simply compile field = value
        if (!is_array($value) && $operator === self::EQUALS) {
            return "{$conjunction}{$field}={$value}";
        }

        // If operator isn't the default equals operator, then we add it to
        // the array structure and compile it.
        if ($operator !== self::EQUALS) {
            return $conjunction . $this->compileArray([ $field => [ $operator => $value ]]);
        }

        // Otherwise, it means that the default equals operator has been given,
        // yet the value is an array and must therefore also be compiled as such.
        return $conjunction . $this->compileArray([ $field => $value ]);
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
        $conjunction = $this->resolveConjunction($where[self::CONJUNCTION]);

        return trim($conjunction . $this->compileExpression($where[self::FIELD], $where[self::BINDINGS]));
    }

    /**
     * Compiles a list of resources to be included
     *
     * @param string[] $includes [optional]
     *
     * @return string
     */
    protected function compileIncludes(array $includes = []): string
    {
        if (empty($includes)) {
            return '';
        }

        $output = [];
        foreach ($includes as $resource) {
            $output[] = $this->compileInclude($resource);
        }

        return $this->includeKey . '=' . implode(',', $output);
    }

    /**
     * Compiles a single resource to be included
     *
     * @param string $resource
     *
     * @return string
     */
    protected function compileInclude(string $resource): string
    {
        return trim($resource);
    }

    /**
     * Compiles limit, if any given
     *
     * @param int|null $amount [optional]
     *
     * @return string Limit or empty string if no amount given
     */
    protected function compileLimit(int|null $amount = null): string
    {
        if (empty($amount)) {
            return '';
        }

        return $this->limitKey . '=' . $amount;
    }

    /**
     * Compiles offset, if any given
     *
     * @param int|null $offset [optional]
     *
     * @return string Limit or empty string if no offset given
     */
    protected function compileOffset(int|null $offset = null): string
    {
        if (empty($offset)) {
            return '';
        }

        return $this->offsetKey . '=' . $offset;
    }

    /**
     * Compiles page number, if any given
     *
     * @param int|null $number [optional]
     *
     * @return string Page number or empty string if page number given
     */
    protected function compilePageNumber(int|null $number = null): string
    {
        if (empty($number)) {
            return '';
        }

        return $this->pageNumberKey . '=' . $number;
    }

    /**
     * Compiles page size, if any given
     *
     * @param int|null $amount [optional]
     *
     * @return string Page size or empty string if no amount given
     */
    protected function compilePageSize(int|null $amount = null): string
    {
        if (empty($amount)) {
            return '';
        }

        return $this->pageSizeKey . '=' . $amount;
    }

    /**
     * Compiles the sorting criteria
     *
     * @param array $orderBy [optional]
     *
     * @return string
     */
    protected function compileOrderBy(array $orderBy = []): string
    {
        if (empty($orderBy)) {
            return '';
        }

        $output = [];
        foreach ($orderBy as $criteria) {
            $output[] = $this->compileSortingCriteria($criteria);
        }

        return $this->orderByKey . '=' . implode(',', $output);
    }

    /**
     * Compiles a single sorting criteria (field and direction)
     *
     * @param array $criteria
     *
     * @return string
     */
    protected function compileSortingCriteria(array $criteria): string
    {
        $field = $criteria[self::FIELD];
        $direction = $criteria[self::DIRECTION];

        return "{$field} {$direction}";
    }

    /**
     * Compiles raw expressions
     *
     * @param array $expressions [optional]
     *
     * @return string Compiled expressions or empty string if none given
     */
    protected function compileRawExpressions(array $expressions = []): string
    {
        if (empty($expressions)) {
            return '';
        }

        $output = [];
        foreach ($expressions as $expression) {
            $output[] = $this->compileExpression($expression[self::EXPRESSION], $expression[self::BINDINGS]);
        }

        return implode($this->resolveParameterSeparator(), $output);
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
     * Method might alter the given operator, if required.
     *
     * @param mixed $operator
     * @param string $field
     *
     * @return string
     *
     * @throws HttpQueryBuilderException
     */
    protected function resolveOperator(mixed $operator, string $field): string
    {
        if (!is_string($operator)) {
            throw new UnableToBuildHttpQuery(sprintf('Expected string operator for %s, %s given', $field, gettype($operator)));
        }

        return trim($operator);
    }

    /**
     * Resolve the conjunction for "where" conditions
     *
     * @param string $conjunction Conjunction identifier or special symbol
     *
     * @return string
     */
    protected function resolveConjunction(string $conjunction): string
    {
        if ($conjunction === self::AND_CONJUNCTION) {
            return $this->options[self::AND_SEPARATOR] ?? $this->defaultAndSeparator;
        } elseif ($conjunction === self::OR_CONJUNCTION) {
            return $this->options[self::OR_SEPARATOR] ?? $this->defaultOrSeparator;
        } else {
            return $conjunction;
        }
    }

    /**
     * Resolves the given value
     *
     * Method might alter the given value, if required.
     *
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws HttpQueryBuilderException
     */
    protected function resolveValue(mixed $value): mixed
    {
        try {
            if (is_null($value)) {
                return 'null';
            }

            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }

            if ($value instanceof DateValue) {
                return $this->compileDate($value);
            }

            if (is_callable($value)) {
                return $value();
            }

            return $value;
        } catch (Throwable $e) {
            throw new UnableToBuildHttpQuery('Value cannot be resolved: ' . $e->getMessage(), $e->getCode(), $e);
        }
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
        // Build a http query using PHP's native method.
        // However, decode the output or we risk that the
        // Request Builder's driver might dual url-encode it.
        return urldecode(http_build_query($params));
    }

    /**
     * Compile given date-value
     *
     * Method will format the given date according to the requested
     * format.
     *
     * @param DateValue $value
     * @return string
     *
     * @throws Exception
     */
    protected function compileDate(DateValue $value): string
    {
        // Resolve the date given. Note that a string date might
        // have been provided. If this is the case, then we need
        // to build a valid DateTime instance, so it can be formatted.
        $date = $value->date() ?? new DateTime('now');
        if (is_string($date)) {
            $date = new DateTime($date);
        }

        // Format the date according to the requested date format.
        return $date->format(
            $this->resolveDateFormat($value->format())
        );
    }

    /**
     * Returns a valid PHP date format, based on the requested
     * format
     *
     * @see https://www.php.net/manual/en/function.date.php
     *
     * @param string $format Requested format
     *
     * @return string
     */
    protected function resolveDateFormat(string $format): string
    {
        return match ($format) {
            self::DATE_FORMAT => $this->options[$format] ?? 'Y-m-d',
            self::YEAR_FORMAT => $this->options[$format] ?? 'Y',
            self::MONTH_FORMAT => $this->options[$format] ?? 'm',
            self::DAY_FORMAT => $this->options[$format] ?? 'd',
            self::TIME_FORMAT => $this->options[$format] ?? 'H:i:s',
            self::DATETIME_FORMAT => $this->options[$format] ?? DateTimeInterface::RFC3339,
            default => $this->options[$format] ?? DateTimeInterface::RFC3339
        };
    }

    /**
     * Resolves the http query parameter separator symbol
     *
     * @return string
     */
    protected function resolveParameterSeparator(): string
    {
        return $this->options[self::PARAMETER_SEPARATOR] ?? $this->defaultParameterSeparator;
    }
}
