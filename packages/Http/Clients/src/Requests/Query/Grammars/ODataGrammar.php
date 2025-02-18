<?php

namespace Aedart\Http\Clients\Requests\Query\Grammars;

use Aedart\Http\Clients\Exceptions\UnableToBuildHttpQuery;

/**
 * Open Data Protocol Grammar
 *
 * Offers basic support for OData v4.x grammar.
 *
 * @see https://www.odata.org/
 * @see http://docs.oasis-open.org/odata/odata/v4.0/odata-v4.0-part2-url-conventions.html
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query\Grammars
 */
class ODataGrammar extends BaseGrammar
{
    /**
     * Default "and where" separator
     *
     * @var string
     */
    protected string $defaultAndSeparator = 'and';

    /**
     * Default "or where" separator
     *
     * @var string
     */
    protected string $defaultOrSeparator = 'or';

    /**
     * Select key, prefix for selects
     *
     * @var string
     */
    protected string $selectKey = '$select';

    /**
     * Filter key
     *
     * @var string
     */
    protected string $filterKey = '$filter';

    /**
     * Include key, prefix for includes
     *
     * @var string
     */
    protected string $includeKey = '$expand';

    /**
     * Limit key, prefix
     *
     * @var string
     */
    protected string $limitKey = '$top';

    /**
     * Offset key, prefix
     *
     * @var string
     */
    protected string $offsetKey = '$skip';

    /**
     * Sorting key, prefix for "order by" criteria
     *
     * @var string
     */
    protected string $orderByKey = '$orderby';

    /**
     * Operator map
     *
     * NOTE: Intended to contain only a comparison
     * operators that are mapped to OData's logical
     * operators
     *
     * @see resolveOperator
     *
     * @var array
     */
    protected array $operatorMap = [
        '=' => 'eq',
        '!=' => 'ne',
        '<' => 'lt',
        '<=' => 'le',
        '>' => 'gt',
        '>=' => 'ge',
        '&&' => 'and',
        '||' => 'or',
        '!' => 'not'
    ];

    /**
     * Determine if string values should be quoted with
     * single quotes
     *
     * @return bool
     */
    public function mustQuoteStringValues(): bool
    {
        return $this->options['quote_strings'] ?? false;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function compileWheres(array $wheres = []): string
    {
        $compiled = parent::compileWheres($wheres);
        if (empty($compiled)) {
            return '';
        }

        return $this->filterKey . '=' . trim($compiled);
    }

    /**
     * @inheritdoc
     */
    protected function compileRegularWhere(array $where): string
    {
        $field = $where[self::FIELD];
        $operator = $this->resolveOperator($where[self::OPERATOR], $field);
        $value = $this->resolveValue($where[self::VALUE]);
        $conjunction = $this->resolveConjunction($where[self::CONJUNCTION]);

        // Compile the filter...
        return " {$conjunction} {$field} {$operator} {$value}";
    }

    /**
     * @inheritdoc
     */
    protected function compileRawWhere(array $where): string
    {
        $conjunction = ' ' . $this->resolveConjunction($where[self::CONJUNCTION]) . ' ';

        return rtrim($conjunction . $this->compileExpression($where[self::FIELD], $where[self::BINDINGS]));
    }

    /**
     * @inheritdoc
     */
    protected function resolveOperator(mixed $operator, string $field): string
    {
        if (!is_string($operator)) {
            throw new UnableToBuildHttpQuery(sprintf('Expected string operator for %s, %s given', $field, gettype($operator)));
        }

        // Convert operator, if possible
        $operator = trim($operator);
        if (isset($this->operatorMap[$operator])) {
            return $this->operatorMap[$operator];
        }

        // Otherwise, we just return the given operator
        return $operator;
    }

    /**
     * @inheritdoc
     */
    protected function resolveValue(mixed $value): mixed
    {
        if (is_array($value)) {
            return '(' . $this->compileArray($value) . ')';
        }

        if (is_string($value) && $this->mustQuoteStringValues()) {
            return $this->quote($value);
        }

        return parent::resolveValue($value);
    }

    /**
     * @inheritdoc
     */
    protected function resolveConjunction(string $conjunction): string
    {
        // Unlike other grammars, we do not allow custom symbols to be
        // specified for and / or conjunctions.
        if ($conjunction === self::AND_CONJUNCTION) {
            return $this->defaultAndSeparator;
        } elseif ($conjunction === self::OR_CONJUNCTION) {
            return $this->defaultOrSeparator;
        } else {
            return $conjunction;
        }
    }

    /**
     * @inheritdoc
     */
    protected function compileArray(array $params): string
    {
        array_walk($params, function ($value) {
            return $this->resolveValue($value);
        });

        return implode(',', $params);
    }

    /**
     * Quote given value
     *
     * @param string $value
     *
     * @return string
     */
    protected function quote(string $value): string
    {
        return "'{$value}'";
    }

    /**
     * {@inheritdoc}
     *
     * Not supported
     */
    protected function compilePageNumber(int|null $number = null): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     *
     * Not supported
     */
    protected function compilePageSize(int|null $amount = null): string
    {
        return '';
    }
}
