<?php

namespace Aedart\Http\Clients\Requests\Query;

use Aedart\Contracts\Http\Clients\Requests\Query\Builder as QueryBuilder;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\GrammarManagerAware;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\Manager;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Http\Clients\Traits\GrammarManagerTrait;
use Aedart\Http\Clients\Traits\GrammarTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Aedart\Utils\Arr;
use Illuminate\Contracts\Container\Container;

/**
 * Http Query Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query
 */
class Builder implements
    QueryBuilder,
    ContainerAware,
    GrammarManagerAware
{
    use ContainerTrait;
    use GrammarManagerTrait;
    use GrammarTrait;

    /**
     * The fields to be selected
     *
     * @var array
     */
    protected array $selects = [];

    /**
     * Where conditions
     *
     * @var array
     */
    protected array $wheres = [];

    /**
     * Includes
     *
     * @var array
     */
    protected array $includes = [];

    /**
     * Limit
     *
     * @var int|null
     */
    protected ?int $limit = null;

    /**
     * Offset
     *
     * @var int|null
     */
    protected ?int $offset = null;

    /**
     * Sorting order criteria
     *
     * @var array
     */
    protected array $orderBy = [];

    /**
     * Builder constructor.
     *
     * @param string|Grammar|null $grammar [optional] String profile name, {@see Grammar} instance or null.
     *                          If null is given, then a default Grammar is resolved
     * @param Container|null $container [optional]
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    public function __construct($grammar = null, ?Container $container = null)
    {
        $this
            ->setContainer($container)
            ->resolveGrammar($grammar);
    }
    
    /**
     * @inheritDoc
     */
    public function select($field, ?string $resource = null): QueryBuilder
    {
        if (is_array($field)) {
            return $this->addSelect($field);
        }

        return $this->addSelect([ $field => $resource ]);
    }

    /**
     * @inheritDoc
     */
    public function selectRaw(string $expression, array $bindings = []): QueryBuilder
    {
        return $this->addSelect([$expression], $bindings, self::SELECT_TYPE_RAW);
    }

    /**
     * @inheritDoc
     */
    public function where($field, $operator = null, $value = null): QueryBuilder
    {
        // When field is an array, we assume that multiple where conditions is
        // desired added
        if (is_array($field)) {
            return $this->addMultipleWhere($field);
        }

        // Set value to be operator, in case that only two arguments
        // have been provided
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = self::EQUALS;
        }

        // Finally, add a regular where condition
        return $this->addRegularWhere($field, $operator, $value);
    }

    /**
     * @inheritDoc
     */
    public function whereRaw(string $query, array $bindings = []): QueryBuilder
    {
        return $this->addRawWhere($query, $bindings);
    }

    /**
     * @inheritDoc
     */
    public function include($resource): QueryBuilder
    {
        if (!is_array($resource)) {
            $resource = [$resource];
        }

        $this->includes = array_merge($this->includes, $resource);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function limit(int $amount): QueryBuilder
    {
        $this->limit = $amount;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function offset(int $offset): QueryBuilder
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function take(int $amount): QueryBuilder
    {
        return $this->limit($amount);
    }

    /**
     * @inheritDoc
     */
    public function skip(int $offset): QueryBuilder
    {
        return $this->offset($offset);
    }

    /**
     * @inheritDoc
     */
    public function orderBy($field, string $direction = QueryBuilder::ASCENDING): QueryBuilder
    {
        if (is_array($field)) {
            return $this->addMultipleOrderBy($field);
        }

        return $this->addOrderBy($field, $direction);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            self::SELECTS => $this->selects,
            self::WHERES => $this->wheres,
            self::INCLUDES => $this->includes,
            self::LIMIT => $this->limit,
            self::OFFSET => $this->offset,
            self::ORDER_BY => $this->orderBy
        ];
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        return $this->getGrammar()->compile($this);
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function getDefaultGrammarManager(): ?Manager
    {
        // We have to respect the IoC container instance
        // that MIGHT have been set via the constructor or
        // mutator.
        return $this->getContainer()->make(Manager::class);
    }

    /**
     * @inheritdoc
     */
    public function getDefaultGrammar(): ?Grammar
    {
        return $this->getGrammarManager()->profile();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolve the given http query grammar
     *
     * @param string|Grammar|null $grammar [optional] String profile name, {@see Grammar} instance or null.
     *                          If null is given, then a default Grammar is resolved
     *
     * @return self
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    protected function resolveGrammar($grammar = null)
    {
        // If no grammar has been given, then abort and allow the
        // default to be set via "getDefaultGrammar" ~ default profile.
        if (!isset($grammar)) {
            return $this;
        }

        // If identifier (profile) has been given, obtain it via the
        // manager, so it can be used.
        if (is_string($grammar)) {
            $grammar = $this->getGrammarManager()->profile($grammar);
        }

        return $this->setGrammar($grammar);
    }

    /**
     * Add a list of fields to be selected
     *
     * @param array $fields Key = field to select, value = from resource (optional)
     * @param array $bindings [optional] Evt. bindings
     * @param string $type [optional] Select type
     *
     * @return QueryBuilder
     */
    protected function addSelect(array $fields, array $bindings = [], string $type = self::SELECT_TYPE_REGULAR): QueryBuilder
    {
        $this->selects[] = [
            self::TYPE => $type,
            self::FIELDS => $fields,
            self::BINDINGS => $bindings
        ];

        return $this;
    }

    /**
     * Add multiple "where" conditions
     *
     * @param array $conditions [optional]
     *
     * @return QueryBuilder
     */
    protected function addMultipleWhere(array $conditions = []): QueryBuilder
    {
        foreach ($conditions as $field => $value) {
            // Determine if one or more operators has been given
            // via the value of the field. If so, then we consider these
            // to be multiple where conditions, with an operator.
            if (is_array($value) && Arr::isAssoc($value)) {
                $this->addMultipleWhereForField($field, $value);
                continue;
            }

            // Otherwise, we assume that an equals operator is intended
            // and add it as a regular "where" condition
            $this->addRegularWhere($field, self::EQUALS, $value);
        }

        return $this;
    }

    /**
     * Add multiple "where" conditions for a single field,
     *
     * @param string $field
     * @param array $operatorsAndValues Key-value pair, where key = operator
     *
     * @return QueryBuilder
     */
    protected function addMultipleWhereForField(string $field, array $operatorsAndValues): QueryBuilder
    {
        foreach ($operatorsAndValues as $operator => $value) {
            $this->addRegularWhere($field, $operator, $value);
        }

        return $this;
    }

    /**
     * Add a regular "where" condition
     *
     * @param string $field
     * @param string $operator [optional]
     * @param mixed $value [optional]
     *
     * @return QueryBuilder
     */
    protected function addRegularWhere(string $field, string $operator = '=', $value = null): QueryBuilder
    {
        return $this->appendWhereCondition([
            self::FIELD => $field,
            self::OPERATOR => $operator,
            self::VALUE => $value
        ], []);
    }

    /**
     * Add a raw "where" condition
     *
     * @param string $expression
     * @param array $bindings [optional]
     *
     * @return QueryBuilder
     */
    protected function addRawWhere(string $expression, array $bindings = []): QueryBuilder
    {
        return $this->appendWhereCondition([
            self::FIELD => $expression,
            self::OPERATOR => null,
            self::VALUE => null
        ], $bindings, self::WHERE_TYPE_RAW);
    }

    /**
     * Appends a "where" condition to builder's list of conditions
     *
     * @param array $where
     * @param array $bindings [optional]
     * @param string $type [optional]
     *
     * @return QueryBuilder
     */
    protected function appendWhereCondition(
        array $where,
        array $bindings = [],
        string $type = self::WHERE_TYPE_REGULAR
    ): QueryBuilder {
        // Add bindings, type, ...etc to where condition
        $where[self::BINDINGS] = $bindings;
        $where[self::TYPE] = $type;

        // Finally, add the where condition to list of conditions
        $this->wheres[] = $where;

        return $this;
    }

    /**
     * Add multiple sorting order criteria
     *
     * @see addOrderBy
     *
     * @param array $criteria
     *
     * @return QueryBuilder
     */
    protected function addMultipleOrderBy(array $criteria): QueryBuilder
    {
        foreach ($criteria as $field => $direction) {
            if (is_int($field)) {
                $field = $direction;
                $direction = self::ASCENDING;
            }

            $this->addOrderBy($field, $direction);
        }

        return $this;
    }

    /**
     * Add sorting order criteria for a field
     *
     * @param string $field
     * @param string $direction
     *
     * @return QueryBuilder
     */
    protected function addOrderBy(string $field, string $direction): QueryBuilder
    {
        $this->orderBy[] = [
            self::FIELD => $field,
            self::DIRECTION => $direction
        ];

        return $this;
    }
}
