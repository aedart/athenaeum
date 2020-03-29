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

        return $this->selectKey . '=' . implode('', $output);
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
                $output[] = $from;
                continue;
            }

            // When "from resource" isn't provided
            if(empty($from)){
                $output[] = $field;
                continue;
            }

            // When "from resource" and field is given
            $output[] = "{$from}.{$field}";
        }

        return implode(',', $output);
    }

    protected function compileRawSelect(array $select): string
    {

    }
}
