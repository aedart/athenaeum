<?php

namespace Aedart\Http\Clients\Requests\Query\Grammars;

use Aedart\Contracts\Http\Clients\Requests\Query\Builder;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Contracts\Http\Clients\Requests\Query\Identifiers;

/**
 * Base Http Query Grammar
 *
 * Abstraction for Http Query Grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query\Grammars
 */
abstract class BaseGrammar implements Grammar,
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
     */
    protected function compileHttpQueryParts(array $parts = []): string
    {
        if(empty($parts)){
            return '';
        }

        return '?' . implode('&', [
            $this->compileSelects($parts[self::SELECTS])
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
        if(empty($selects)){
            return '';
        }

        $output = [];
        foreach ($selects as $select){
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
        if($select[self::TYPE] === self::SELECT_TYPE_RAW){
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
        foreach ($fields as $field => $from){
            // When an expression is given
            if(is_numeric($field)){
                $output[] = trim($from);
                continue;
            }

            // When "from resource" isn't provided
            if(empty($from)){
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
        if(empty($bindings)){
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
}
